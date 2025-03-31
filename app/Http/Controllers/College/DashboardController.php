<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Funding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the college dashboard
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $collegeId = Auth::user()->college_id;
        
        // Get total bills count
        $totalBills = Bill::where('college_id', $collegeId)->count();
        
        // Get pending bills count
        $pendingBills = Bill::where('college_id', $collegeId)
            ->where('bill_status', 'pending')
            ->count();
        
        // Get bills that need payment records
        // These are approved bills where the total payments don't match the bill amount
        $billsNeedingPaymentRecords = Bill::where('college_id', $collegeId)
            ->where('bill_status', 'approved')
            ->whereRaw('(SELECT COALESCE(SUM(payment_amt), 0) FROM payments WHERE payments.bill_id = bills.bill_id) < bill_amt')
            ->count();
        
        // Get recent bills
        $recentBills = Bill::where('college_id', $collegeId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get recent payments
        $recentPayments = DB::table('payments')
            ->join('bills', 'payments.bill_id', '=', 'bills.bill_id')
            ->where('bills.college_id', $collegeId)
            ->select('payments.*', 'bills.bill_no')
            ->orderBy('payments.created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get funding information
        $fundingInfo = Funding::where('college_id', $collegeId)
            ->select(
                DB::raw('SUM(approved_amt) as total_funding'),
                DB::raw('(SELECT SUM(bill_amt) FROM bills WHERE college_id = '.$collegeId.' AND bill_status = "approved") as utilized_funding')
            )
            ->first();
        
        $totalFunding = $fundingInfo->total_funding ?? 0;
        $utilizedFunding = $fundingInfo->utilized_funding ?? 0;
        
        // Get released funding amount
        $releasedFunding = DB::table('releases')
            ->join('fundings', 'releases.funding_id', '=', 'fundings.funding_id')
            ->where('fundings.college_id', $collegeId)
            ->sum('releases.release_amt');
        
        // Calculate funding utilization percentage
        $fundingUtilizationPercent = 0;
        if ($releasedFunding > 0) {
            $fundingUtilizationPercent = round(($utilizedFunding / $releasedFunding) * 100, 2);
        }
        
        // Calculate funding release percentage
        $fundingReleasePercent = 0;
        if ($totalFunding > 0) {
            $fundingReleasePercent = round(($releasedFunding / $totalFunding) * 100, 2);
        }
        
        return view('college.dashboard', compact(
            'totalBills',
            'pendingBills',
            'billsNeedingPaymentRecords',
            'recentBills',
            'recentPayments',
            'totalFunding',
            'releasedFunding',
            'utilizedFunding',
            'fundingUtilizationPercent',
            'fundingReleasePercent'
        ));
    }
} 