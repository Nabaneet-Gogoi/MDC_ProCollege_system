<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collegeId = Auth::user()->college_id;
        
        // Get all payments for bills belonging to this college
        $payments = Payment::whereHas('bill', function($query) use ($collegeId) {
            $query->where('college_id', $collegeId);
        })
        ->with('bill')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        // Get bills for this college for the filter
        $bills = Bill::where('college_id', $collegeId)->get();
        
        return view('college.payments.index', compact('payments', 'bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collegeId = Auth::user()->college_id;
        
        // Get approved or paid bills that belong to this college for the dropdown
        $bills = Bill::where('college_id', $collegeId)
            ->whereIn('bill_status', ['approved', 'paid'])
            ->get();
            
        if ($bills->isEmpty()) {
            return redirect()->route('college.payments.index')
                ->with('info', 'No approved bills are available for recording payments.');
        }
        
        return view('college.payments.create', compact('bills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $collegeId = Auth::user()->college_id;
        
        // Validate payment data
        $request->validate([
            'bill_id' => 'required|exists:bills,bill_id',
            'payment_amt' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'transaction_reference' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        // Make sure the bill belongs to this college
        $bill = Bill::where('college_id', $collegeId)
            ->where('bill_id', $request->bill_id)
            ->firstOrFail();
        
        // Calculate total payments already made for this bill
        $existingPayments = Payment::where('bill_id', $bill->bill_id)->sum('payment_amt');
        $remainingAmount = $bill->bill_amt - $existingPayments;
        
        if ($request->payment_amt > $remainingAmount) {
            return back()->withInput()->with('error', 
                'Payment amount exceeds the remaining bill amount. Maximum allowed: ' . $remainingAmount);
        }
        
        DB::beginTransaction();
        
        try {
            // Create payment record - always starts as pending
            $payment = Payment::create([
                'bill_id' => $request->bill_id,
                'payment_amt' => $request->payment_amt,
                'payment_date' => $request->payment_date,
                'payment_status' => 'pending', // College users can only create pending payments
                'transaction_reference' => $request->transaction_reference,
                'remarks' => $request->remarks,
            ]);
            
            DB::commit();
            
            return redirect()->route('college.payments.show', $payment->payment_id)
                ->with('success', 'Payment record created successfully. It will be reviewed by an administrator.');
                
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
        $collegeId = Auth::user()->college_id;
        
        // Get the payment and ensure it belongs to a bill from this college
        $payment = Payment::whereHas('bill', function($query) use ($collegeId) {
            $query->where('college_id', $collegeId);
        })
        ->with(['bill.college', 'bill.funding'])
        ->findOrFail($id);
        
        return view('college.payments.show', compact('payment'));
    }
    
    /**
     * Filter payments by various criteria.
     */
    public function filter(Request $request)
    {
        $collegeId = Auth::user()->college_id;
        
        $query = Payment::whereHas('bill', function($query) use ($collegeId) {
            $query->where('college_id', $collegeId);
        })->with('bill');
        
        // Apply filters
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
        
        // Get bills for filter dropdown
        $bills = Bill::where('college_id', $collegeId)->get();
        
        return view('college.payments.index', compact('payments', 'bills'));
    }
} 