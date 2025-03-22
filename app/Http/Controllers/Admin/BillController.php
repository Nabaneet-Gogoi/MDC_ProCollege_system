<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\College;
use App\Models\WorkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::with(['college', 'funding', 'progress'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin doesn't create bills directly - this is for college users
        return redirect()->route('admin.bills.index')
            ->with('error', 'Bills can only be created by college users.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin doesn't create bills directly - this is for college users
        return redirect()->route('admin.bills.index')
            ->with('error', 'Bills can only be created by college users.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::with(['college', 'funding', 'progress.category', 'user'])
            ->findOrFail($id);
            
        return view('admin.bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Admin doesn't edit bill details directly - they only approve/reject or change status
        return redirect()->route('admin.bills.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Basic validation just for the status
        $request->validate([
            'bill_status' => 'required|in:pending,approved,rejected,paid',
            'admin_remarks' => 'nullable|string|max:500',
        ]);
        
        $bill = Bill::findOrFail($id);
        
        // Update bill status
        $bill->update([
            'bill_status' => $request->bill_status,
            'admin_remarks' => $request->admin_remarks,
        ]);
        
        return redirect()->route('admin.bills.show', $bill->bill_id)
            ->with('success', "Bill status updated to '{$request->bill_status}' successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Admin should not delete bills
        return redirect()->route('admin.bills.index')
            ->with('error', 'Bills cannot be deleted by administrators.');
    }
    
    /**
     * Update the bill status.
     */
    public function updateStatus(Request $request, string $id)
    {
        // Validate status
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,paid',
            'admin_remarks' => 'nullable|string|max:500',
        ]);
        
        $bill = Bill::findOrFail($id);
        
        // Update bill status
        $bill->update([
            'bill_status' => $request->status,
            'admin_remarks' => $request->admin_remarks,
        ]);
        
        return redirect()->route('admin.bills.show', $bill->bill_id)
            ->with('success', "Bill status updated to '{$request->status}' successfully.");
    }
    
    /**
     * Filter bills by various criteria.
     */
    public function filter(Request $request)
    {
        $query = Bill::query()->with(['college', 'funding', 'progress']);
        
        // Apply filters
        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }
        
        if ($request->filled('status')) {
            $query->where('bill_status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('bill_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('bill_date', '<=', $request->date_to);
        }
        
        // Get results with pagination
        $bills = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get colleges for filter dropdown
        $colleges = College::orderBy('college_name')->get();
        
        return view('admin.bills.index', compact('bills', 'colleges'));
    }
}
