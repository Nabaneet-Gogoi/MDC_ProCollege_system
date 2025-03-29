<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\College;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['bill.college'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get bills that are approved but not paid
        $bills = Bill::where('bill_status', 'approved')
            ->with('college')
            ->get();
            
        if ($bills->isEmpty()) {
            return redirect()->route('admin.payments.index')
                ->with('info', 'No approved bills are available for payment.');
        }
        
        $statuses = Payment::getStatusOptions();
        
        return view('admin.payments.create', compact('bills', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate payment data
        $request->validate([
            'bill_id' => 'required|exists:bills,bill_id',
            'payment_amt' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_status' => 'required|in:pending,completed',
            'transaction_reference' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        // Get the bill to ensure payment amount doesn't exceed bill amount
        $bill = Bill::findOrFail($request->bill_id);
        
        // Calculate total payments already made for this bill
        $existingPayments = Payment::where('bill_id', $bill->bill_id)->sum('payment_amt');
        $remainingAmount = $bill->bill_amt - $existingPayments;
        
        if ($request->payment_amt > $remainingAmount) {
            return back()->withInput()->with('error', 
                'Payment amount exceeds the remaining bill amount. Maximum allowed: ' . $remainingAmount);
        }
        
        DB::beginTransaction();
        
        try {
            // Create payment record
            $payment = Payment::create([
                'bill_id' => $request->bill_id,
                'payment_amt' => $request->payment_amt,
                'payment_date' => $request->payment_date,
                'payment_status' => $request->payment_status,
                'transaction_reference' => $request->transaction_reference,
                'remarks' => $request->remarks,
            ]);
            
            // Update bill status to paid if full amount is paid
            $totalPaid = $existingPayments + $request->payment_amt;
            if ($totalPaid >= $bill->bill_amt) {
                $bill->update(['bill_status' => 'paid']);
            }
            
            DB::commit();
            
            return redirect()->route('admin.payments.show', $payment->payment_id)
                ->with('success', 'Payment recorded successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 
                'An error occurred while recording the payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['bill.college', 'bill.funding'])
            ->findOrFail($id);
            
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::with('bill.college')
            ->findOrFail($id);
            
        // Only pending or processed payments can be edited
        if (!in_array($payment->payment_status, ['pending', 'processed'])) {
            return redirect()->route('admin.payments.show', $payment->payment_id)
                ->with('error', 'Only pending or processed payments can be edited.');
        }
        
        $statuses = Payment::getStatusOptions();
        
        return view('admin.payments.edit', compact('payment', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate payment data
        $request->validate([
            'payment_status' => 'required|in:pending,completed',
            'transaction_reference' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        $payment = Payment::findOrFail($id);
        
        // Only pending or processed payments can be edited
        if (!in_array($payment->payment_status, ['pending', 'processed'])) {
            return redirect()->route('admin.payments.show', $payment->payment_id)
                ->with('error', 'Only pending or processed payments can be edited.');
        }
        
        // Update payment status
        $payment->update([
            'payment_status' => $request->payment_status,
            'transaction_reference' => $request->transaction_reference,
            'remarks' => $request->remarks,
        ]);
        
        // If payment is completed, check if bill should be marked as paid
        if ($request->payment_status === 'completed') {
            $bill = Bill::find($payment->bill_id);
            $totalPaid = Payment::where('bill_id', $bill->bill_id)
                ->where('payment_status', 'completed')
                ->sum('payment_amt');
                
            if ($totalPaid >= $bill->bill_amt) {
                $bill->update(['bill_status' => 'paid']);
            }
        }
        
        return redirect()->route('admin.payments.show', $payment->payment_id)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        
        // Only pending payments can be deleted
        if ($payment->payment_status !== 'pending') {
            return redirect()->route('admin.payments.show', $payment->payment_id)
                ->with('error', 'Only pending payments can be deleted.');
        }
        
        $payment->delete();
        
        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
    
    /**
     * Update payment status.
     */
    public function updateStatus(Request $request, string $id)
    {
        // Validate status
        $request->validate([
            'status' => 'required|in:pending,completed',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        $payment = Payment::findOrFail($id);
        
        // Update payment status
        $payment->update([
            'payment_status' => $request->status,
            'remarks' => $request->remarks,
        ]);
        
        // If payment is completed, check if bill should be marked as paid
        if ($request->status === 'completed') {
            $bill = Bill::find($payment->bill_id);
            $totalPaid = Payment::where('bill_id', $bill->bill_id)
                ->where('payment_status', 'completed')
                ->sum('payment_amt');
                
            if ($totalPaid >= $bill->bill_amt) {
                $bill->update(['bill_status' => 'paid']);
            }
        }
        
        return redirect()->route('admin.payments.show', $payment->payment_id)
            ->with('success', "Payment status updated to '{$request->status}' successfully.");
    }
    
    /**
     * Filter payments by various criteria.
     */
    public function filter(Request $request)
    {
        $query = Payment::with(['bill.college']);
        
        // Apply filters
        if ($request->has('college_id') && $request->college_id) {
            $query->whereHas('bill', function($query) use ($request) {
                $query->where('college_id', $request->college_id);
            });
        }
        
        if ($request->has('bill_id') && $request->bill_id) {
            $query->where('bill_id', $request->bill_id);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('payment_status', $request->status);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->where('payment_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->where('payment_date', '<=', $request->date_to);
        }
        
        // Sort results
        $sortField = $request->get('sort_field', 'payment_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $payments = $query->paginate(10)->withQueryString();
        
        // Get colleges and statuses for filter dropdowns
        $colleges = College::all();
        $statuses = Payment::getStatusOptions();
        
        return view('admin.payments.index', compact('payments', 'colleges', 'statuses'));
    }
} 