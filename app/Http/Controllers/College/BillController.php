<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillProgress;
use App\Models\WorkCategory;
use App\Models\Funding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PhysicalProgress;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collegeId = Auth::user()->college_id;
        
        $bills = Bill::where('college_id', $collegeId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('college.bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collegeId = Auth::user()->college_id;
        
        // Get available fundings for the college
        $fundings = Funding::where('college_id', $collegeId)
            ->whereRaw('approved_amt > (SELECT COALESCE(SUM(bill_amt), 0) FROM bills WHERE funding_id = fundings.funding_id)')
            ->get();
            
        // Calculate available released funds for each funding
        foreach ($fundings as $funding) {
            $totalUtilized = Bill::where('funding_id', $funding->funding_id)
                ->where('bill_status', '!=', 'rejected')
                ->sum('bill_amt');
                
            $funding->available_released = $funding->total_released - $totalUtilized;
        }
        
        // Get work categories for dropdown
        $categories = WorkCategory::getCategoriesForDropdown();
        
        // Get latest completion percentages for each work category from previous bills
        $latestProgressByCategory = [];
        $workCategories = WorkCategory::where('is_active', true)->get();
        
        foreach ($workCategories as $category) {
            // Find latest approved bill progress for this category
            $latestProgress = BillProgress::whereHas('bill', function($query) use ($collegeId) {
                    $query->where('college_id', $collegeId)
                          ->whereIn('bill_status', ['approved', 'paid']);
                })
                ->where('category_id', $category->category_id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestProgress) {
                $latestProgressByCategory[$category->category_id] = [
                    'completion_percent' => $latestProgress->completion_percent,
                    'progress_status' => $latestProgress->progress_status,
                    'bill_no' => $latestProgress->bill->bill_no,
                    'bill_date' => $latestProgress->bill->bill_date->format('d M Y')
                ];
            } else {
                // Check physical progress if no bill progress exists
                $physicalProgress = PhysicalProgress::where('college_id', $collegeId)
                    ->where('category_id', $category->category_id)
                    ->orderBy('report_date', 'desc')
                    ->first();
                
                if ($physicalProgress) {
                    $latestProgressByCategory[$category->category_id] = [
                        'completion_percent' => $physicalProgress->completion_percent,
                        'progress_status' => $physicalProgress->progress_status,
                        'report_date' => $physicalProgress->report_date->format('d M Y')
                    ];
                }
            }
        }
        
        return view('college.bills.create', compact('fundings', 'categories', 'latestProgressByCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate bill data
        $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'funding_id' => 'required|exists:fundings,funding_id',
            'bill_amt' => 'required|numeric|min:0.01',
            'bill_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'bill_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'progress' => 'required|array|min:1',
            'progress.*.category_id' => 'required|exists:work_categories,category_id',
            'progress.*.completion_percent' => 'required|numeric|min:0|max:100',
            'progress.*.progress_status' => 'required|in:not_started,in_progress,completed',
            'progress.*.description' => 'nullable|string|max:500',
        ]);
        
        $collegeId = $request->college_id;
        
        // Validate that completion percentages don't decrease
        $validationErrors = [];
        foreach ($request->progress as $index => $progressData) {
            $categoryId = $progressData['category_id'];
            $newCompletionPercent = (float)$progressData['completion_percent'];
            
            // Find the latest progress for this category
            $latestProgress = BillProgress::whereHas('bill', function($query) use ($collegeId) {
                    $query->where('college_id', $collegeId)
                          ->whereIn('bill_status', ['approved', 'paid']);
                })
                ->where('category_id', $categoryId)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestProgress && $newCompletionPercent < (float)$latestProgress->completion_percent) {
                $validationErrors["progress.{$index}.completion_percent"] = "Completion percentage cannot be less than the previous value of {$latestProgress->completion_percent}%";
                continue;
            }
            
            // If no bill progress, check physical progress
            if (!$latestProgress) {
                $physicalProgress = PhysicalProgress::where('college_id', $collegeId)
                    ->where('category_id', $categoryId)
                    ->orderBy('report_date', 'desc')
                    ->first();
                
                if ($physicalProgress && $newCompletionPercent < (float)$physicalProgress->completion_percent) {
                    $validationErrors["progress.{$index}.completion_percent"] = "Completion percentage cannot be less than the previous value of {$physicalProgress->completion_percent}%";
                }
            }
        }
        
        if (!empty($validationErrors)) {
            return back()->withInput()->withErrors($validationErrors);
        }
        
        // Get the funding
        $funding = Funding::findOrFail($request->funding_id);
        
        // Check total released amount
        $totalReleased = $funding->total_released;
        
        // Get total utilized amount for this funding
        $totalUtilized = Bill::where('funding_id', $request->funding_id)
            ->where('bill_status', '!=', 'rejected')
            ->sum('bill_amt');
        
        // Calculate available amount for billing
        $availableAmount = $totalReleased - $totalUtilized;
        
        // Check if bill amount exceeds available released funds
        if ($request->bill_amt > $availableAmount) {
            return back()->withInput()->withErrors([
                'bill_amt' => "Bill amount (₹{$request->bill_amt} Cr) cannot exceed the available released funds (₹{$availableAmount} Cr)"
            ]);
        }
        
        // Validate funding has enough balance
        $remainingBalance = $funding->remaining_balance;
        
        if ($request->bill_amt > $remainingBalance) {
            return back()->withInput()->withErrors([
                'bill_amt' => "Bill amount cannot exceed the remaining balance of ₹{$remainingBalance} Cr"
            ]);
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Generate bill number
            $billNumber = Bill::generateBillNumber($request->college_id);
            
            // Handle bill image upload
            $billImagePath = null;
            if ($request->hasFile('bill_image')) {
                $billImagePath = $request->file('bill_image')->store('bills/' . $request->college_id, 'public');
            }
            
            // Create the bill
            $bill = Bill::create([
                'college_id' => $request->college_id,
                'funding_id' => $request->funding_id,
                'user_id' => Auth::id(),
                'bill_no' => $billNumber,
                'bill_amt' => $request->bill_amt,
                'bill_date' => $request->bill_date,
                'bill_status' => 'pending',
                'description' => $request->description,
                'bill_image' => $billImagePath,
            ]);
            
            // Create progress records
            foreach ($request->progress as $progressData) {
                BillProgress::create([
                    'bill_id' => $bill->bill_id,
                    'college_id' => $request->college_id,
                    'category_id' => $progressData['category_id'],
                    'completion_percent' => $progressData['completion_percent'],
                    'progress_status' => $progressData['progress_status'],
                    'description' => $progressData['description'] ?? null,
                ]);
            }
            
            // Update funding utilization status based on total bills
            $totalBilled = Bill::where('funding_id', $request->funding_id)->sum('bill_amt');
            $utilizationPercentage = ($totalBilled / $funding->approved_amt) * 100;
            
            if ($utilizationPercentage >= 100) {
                $funding->update(['utilization_status' => 'completed']);
            } elseif ($utilizationPercentage > 0) {
                $funding->update(['utilization_status' => 'in_progress']);
            }
            
            DB::commit();
            
            return redirect()->route('college.bills.show', $bill->bill_id)
                ->with('success', 'Bill submitted successfully. Bill Number: ' . $billNumber);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred while submitting the bill: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $collegeId = Auth::user()->college_id;
        
        $bill = Bill::where('bill_id', $id)
            ->where('college_id', $collegeId)
            ->with(['progress.category', 'funding'])
            ->firstOrFail();
            
        return view('college.bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $collegeId = Auth::user()->college_id;
        
        $bill = Bill::where('bill_id', $id)
            ->where('college_id', $collegeId)
            ->with(['progress.category'])
            ->firstOrFail();
            
        // Only pending bills can be edited
        if ($bill->bill_status !== 'pending') {
            return redirect()->route('college.bills.show', $bill->bill_id)
                ->with('error', 'Only pending bills can be edited.');
        }
        
        $categories = WorkCategory::getCategoriesForDropdown();
        
        // Get latest completion percentages for each work category
        // Here we're looking for the progress that was before this bill
        $latestProgressByCategory = [];
        $workCategories = WorkCategory::where('is_active', true)->get();
        
        foreach ($workCategories as $category) {
            // Get latest approved bill progress for this category (excluding current bill)
            $latestProgress = BillProgress::whereHas('bill', function($query) use ($collegeId, $id) {
                    $query->where('college_id', $collegeId)
                         ->where('bill_id', '!=', $id)
                         ->whereIn('bill_status', ['approved', 'paid']);
                })
                ->where('category_id', $category->category_id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestProgress) {
                $latestProgressByCategory[$category->category_id] = [
                    'completion_percent' => $latestProgress->completion_percent,
                    'progress_status' => $latestProgress->progress_status,
                    'bill_no' => $latestProgress->bill->bill_no,
                    'bill_date' => $latestProgress->bill->bill_date->format('d M Y')
                ];
            } else {
                // Check physical progress if no bill progress exists
                $physicalProgress = PhysicalProgress::where('college_id', $collegeId)
                    ->where('category_id', $category->category_id)
                    ->orderBy('report_date', 'desc')
                    ->first();
                
                if ($physicalProgress) {
                    $latestProgressByCategory[$category->category_id] = [
                        'completion_percent' => $physicalProgress->completion_percent,
                        'progress_status' => $physicalProgress->progress_status,
                        'report_date' => $physicalProgress->report_date->format('d M Y')
                    ];
                }
            }
        }
        
        return view('college.bills.edit', compact('bill', 'categories', 'latestProgressByCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get the bill
        $bill = Bill::where('bill_id', $id)
            ->where('college_id', Auth::user()->college_id)
            ->firstOrFail();
            
        // Check if bill is editable
        if ($bill->bill_status !== 'pending') {
            return back()->with('error', 'Only pending bills can be edited');
        }
        
        // Validate bill data
        $request->validate([
            'funding_id' => 'required|exists:fundings,funding_id',
            'bill_amt' => 'required|numeric|min:0.01',
            'bill_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'bill_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'college_remarks' => 'nullable|string|max:500',
            'progress' => 'required|array|min:1',
            'progress.*.category_id' => 'required|exists:work_categories,category_id',
            'progress.*.completion_percent' => 'required|numeric|min:0|max:100',
            'progress.*.progress_status' => 'required|in:not_started,in_progress,completed',
            'progress.*.description' => 'nullable|string|max:500',
        ]);
        
        $collegeId = $bill->college_id;
        
        // Validate that completion percentages don't decrease
        $validationErrors = [];
        foreach ($request->progress as $index => $progressData) {
            $categoryId = $progressData['category_id'];
            $newCompletionPercent = (float)$progressData['completion_percent'];
            
            // Find the latest approved progress for this category (excluding this bill)
            $latestProgress = BillProgress::whereHas('bill', function($query) use ($collegeId, $id) {
                    $query->where('college_id', $collegeId)
                          ->where('bill_id', '!=', $id)
                          ->whereIn('bill_status', ['approved', 'paid']);
                })
                ->where('category_id', $categoryId)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestProgress && $newCompletionPercent < (float)$latestProgress->completion_percent) {
                $validationErrors["progress.{$index}.completion_percent"] = "Completion percentage cannot be less than the previous value of {$latestProgress->completion_percent}%";
                continue;
            }
            
            // If no bill progress, check physical progress
            if (!$latestProgress) {
                $physicalProgress = PhysicalProgress::where('college_id', $collegeId)
                    ->where('category_id', $categoryId)
                    ->orderBy('report_date', 'desc')
                    ->first();
                
                if ($physicalProgress && $newCompletionPercent < (float)$physicalProgress->completion_percent) {
                    $validationErrors["progress.{$index}.completion_percent"] = "Completion percentage cannot be less than the previous value of {$physicalProgress->completion_percent}%";
                }
            }
        }
        
        if (!empty($validationErrors)) {
            return back()->withInput()->withErrors($validationErrors);
        }
        
        // Get the funding
        $funding = Funding::findOrFail($request->funding_id);
        
        // Check total released amount
        $totalReleased = $funding->total_released;
        
        // Get total utilized amount for this funding (excluding this bill)
        $totalUtilized = Bill::where('funding_id', $request->funding_id)
            ->where('bill_id', '!=', $id)
            ->where('bill_status', '!=', 'rejected')
            ->sum('bill_amt');
        
        // Calculate available amount for billing
        $availableAmount = $totalReleased - $totalUtilized;
        
        // Check if bill amount exceeds available released funds
        if ($request->bill_amt > $availableAmount) {
            return back()->withInput()->withErrors([
                'bill_amt' => "Bill amount (₹{$request->bill_amt} Cr) cannot exceed the available released funds (₹{$availableAmount} Cr)"
            ]);
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Handle bill image upload if a new image is provided
            $billImagePath = $bill->bill_image;
            if ($request->hasFile('bill_image')) {
                // Delete old image if it exists
                if ($billImagePath && \Storage::disk('public')->exists($billImagePath)) {
                    \Storage::disk('public')->delete($billImagePath);
                }
                
                $billImagePath = $request->file('bill_image')->store('bills/' . $collegeId, 'public');
            }
            
            // Update the bill
            $bill->update([
                'funding_id' => $request->funding_id,
                'bill_amt' => $request->bill_amt,
                'bill_date' => $request->bill_date,
                'description' => $request->description,
                'college_remarks' => $request->college_remarks,
                'bill_image' => $billImagePath,
            ]);
            
            // Delete existing progress records
            BillProgress::where('bill_id', $id)->delete();
            
            // Create new progress records
            foreach ($request->progress as $progressData) {
                BillProgress::create([
                    'bill_id' => $id,
                    'college_id' => $collegeId,
                    'category_id' => $progressData['category_id'],
                    'completion_percent' => $progressData['completion_percent'],
                    'progress_status' => $progressData['progress_status'],
                    'description' => $progressData['description'] ?? null,
                ]);
            }
            
            // Update funding utilization status based on total bills
            $totalBilled = Bill::where('funding_id', $request->funding_id)
                ->where('bill_status', '!=', 'rejected')
                ->sum('bill_amt');
                
            $utilizationPercentage = ($totalBilled / $funding->approved_amt) * 100;
            
            if ($utilizationPercentage >= 100) {
                $funding->update(['utilization_status' => 'completed']);
            } elseif ($utilizationPercentage > 0) {
                $funding->update(['utilization_status' => 'in_progress']);
            } else {
                $funding->update(['utilization_status' => 'not_started']);
            }
            
            DB::commit();
            
            return redirect()->route('college.bills.show', $id)
                ->with('success', 'Bill updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred while updating the bill: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $collegeId = Auth::user()->college_id;
        
        $bill = Bill::where('bill_id', $id)
            ->where('college_id', $collegeId)
            ->firstOrFail();
            
        // Only pending bills can be deleted
        if ($bill->bill_status !== 'pending') {
            return redirect()->route('college.bills.show', $bill->bill_id)
                ->with('error', 'Only pending bills can be deleted.');
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Delete progress records first
            BillProgress::where('bill_id', $bill->bill_id)->delete();
            
            // Delete the bill
            $bill->delete();
            
            DB::commit();
            
            return redirect()->route('college.bills.index')
                ->with('success', 'Bill deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while deleting the bill: ' . $e->getMessage());
        }
    }

    /**
     * Display bills for status management.
     */
    public function manageStatus()
    {
        $collegeId = Auth::user()->college_id;
        
        $bills = Bill::where('college_id', $collegeId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('college.bills.manage_status', compact('bills'));
    }

    /**
     * Update the bill status.
     */
    public function updateStatus(Request $request, string $id)
    {
        // Validate status
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,paid',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        $collegeId = Auth::user()->college_id;
        
        $bill = Bill::where('bill_id', $id)
            ->where('college_id', $collegeId)
            ->firstOrFail();
        
        // Update bill status
        $bill->update([
            'bill_status' => $request->status,
            'college_remarks' => $request->remarks,
        ]);
        
        return redirect()->route('college.bills.status.manage')
            ->with('success', "Bill status updated to '{$request->status}' successfully.");
    }
}
