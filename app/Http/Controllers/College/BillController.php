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
        
        return view('college.bills.create', compact('fundings', 'categories'));
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
            'progress' => 'required|array|min:1',
            'progress.*.category_id' => 'required|exists:work_categories,category_id',
            'progress.*.completion_percent' => 'required|numeric|min:0|max:100',
            'progress.*.progress_status' => 'required|in:not_started,in_progress,completed',
            'progress.*.description' => 'nullable|string|max:500',
        ]);
        
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
        
        return view('college.bills.edit', compact('bill', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $collegeId = Auth::user()->college_id;
        
        $bill = Bill::where('bill_id', $id)
            ->where('college_id', $collegeId)
            ->firstOrFail();
            
        // Only pending bills can be updated
        if ($bill->bill_status !== 'pending') {
            return redirect()->route('college.bills.show', $bill->bill_id)
                ->with('error', 'Only pending bills can be updated.');
        }
        
        // Validate bill data
        $request->validate([
            'bill_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'progress' => 'required|array|min:1',
            'progress.*.progress_id' => 'nullable|exists:bill_progress,progress_id',
            'progress.*.category_id' => 'required|exists:work_categories,category_id',
            'progress.*.completion_percent' => 'required|numeric|min:0|max:100',
            'progress.*.progress_status' => 'required|in:not_started,in_progress,completed',
            'progress.*.description' => 'nullable|string|max:500',
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Update bill
            $bill->update([
                'bill_date' => $request->bill_date,
                'description' => $request->description,
            ]);
            
            // Track existing progress IDs to determine which to delete
            $existingProgressIds = $bill->progress->pluck('progress_id')->toArray();
            $updatedProgressIds = [];
            
            // Update or create progress records
            foreach ($request->progress as $progressData) {
                if (!empty($progressData['progress_id'])) {
                    // Update existing progress
                    $progress = BillProgress::findOrFail($progressData['progress_id']);
                    $progress->update([
                        'category_id' => $progressData['category_id'],
                        'completion_percent' => $progressData['completion_percent'],
                        'progress_status' => $progressData['progress_status'],
                        'description' => $progressData['description'] ?? null,
                    ]);
                    
                    $updatedProgressIds[] = $progress->progress_id;
                } else {
                    // Create new progress
                    $progress = BillProgress::create([
                        'bill_id' => $bill->bill_id,
                        'college_id' => $collegeId,
                        'category_id' => $progressData['category_id'],
                        'completion_percent' => $progressData['completion_percent'],
                        'progress_status' => $progressData['progress_status'],
                        'description' => $progressData['description'] ?? null,
                    ]);
                    
                    $updatedProgressIds[] = $progress->progress_id;
                }
            }
            
            // Delete progress records that were removed
            $progressToDelete = array_diff($existingProgressIds, $updatedProgressIds);
            if (!empty($progressToDelete)) {
                BillProgress::whereIn('progress_id', $progressToDelete)->delete();
            }
            
            DB::commit();
            
            return redirect()->route('college.bills.show', $bill->bill_id)
                ->with('success', 'Bill updated successfully.');
                
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
}
