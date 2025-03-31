<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentPrintController extends Controller
{
    /**
     * Generate a print-friendly view of the payment
     * 
     * @param int $id The payment ID
     * @return \Illuminate\View\View
     */
    public function printPayment($id)
    {
        // Check user role for authorization
        if (Auth::guard('admin')->check()) {
            // Admin can view any payment
            $payment = Payment::with(['bill.college', 'bill.funding', 'bill.user'])
                ->findOrFail($id);
        } else if (Auth::user()->isRUSAUser()) {
            // RUSA users can also view any payment
            $payment = Payment::with(['bill.college', 'bill.funding', 'bill.user'])
                ->findOrFail($id);
        } else {
            // College user can only view their own payments
            $collegeId = Auth::user()->college_id;
            $payment = Payment::whereHas('bill', function($query) use ($collegeId) {
                $query->where('college_id', $collegeId);
            })
            ->with(['bill.college', 'bill.funding', 'bill.user'])
            ->findOrFail($id);
        }
        
        return view('payments.print', compact('payment'));
    }
} 