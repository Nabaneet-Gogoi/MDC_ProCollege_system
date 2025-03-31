<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillPrintController extends Controller
{
    /**
     * Generate a print-friendly view of the bill
     * 
     * @param int $id The bill ID
     * @return \Illuminate\View\View
     */
    public function printBill($id)
    {
        // Check user role for authorization
        if (Auth::guard('admin')->check()) {
            // Admin can view any bill
            $bill = Bill::with(['college', 'funding', 'progress.category', 'user'])
                ->findOrFail($id);
        } else if (Auth::user()->isRUSAUser()) {
            // RUSA users can also view any bill
            $bill = Bill::with(['college', 'funding', 'progress.category', 'user'])
                ->findOrFail($id);
        } else {
            // College user can only view their own bills
            $collegeId = Auth::user()->college_id;
            $bill = Bill::where('bill_id', $id)
                ->where('college_id', $collegeId)
                ->with(['college', 'funding', 'progress.category', 'user'])
                ->firstOrFail();
        }
        
        return view('bills.print', compact('bill'));
    }
} 