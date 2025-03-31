<?php

namespace App\Http\Controllers\RUSA;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Funding;
use App\Models\Release;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\PhysicalProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display RUSA user dashboard with monitoring data
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the selected time period from request (default to 'This month')
        $period = $request->input('period', 'This month');
        
        // Calculate the date range based on selected period
        $startDate = null;
        $endDate = Carbon::now();
        
        switch($period) {
            case 'This month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'Last month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'Last 3 months':
                $startDate = Carbon::now()->subMonths(3)->startOfDay();
                break;
            case 'Last 6 months':
                $startDate = Carbon::now()->subMonths(6)->startOfDay();
                break;
            case 'This year':
                $startDate = Carbon::now()->startOfYear();
                break;
            case 'All time':
                $startDate = null; // No start date filter for all time
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                break;
        }
        
        // Get counts for dashboard stats - apply time filters where appropriate
        $collegeCount = College::count(); // Don't filter total colleges
        
        // Bills and Payments can be filtered by time period
        $billQuery = Bill::query();
        $paymentQuery = Payment::query();
        
        if ($startDate) {
            $billQuery->where('bill_date', '>=', $startDate)->where('bill_date', '<=', $endDate);
            $paymentQuery->where('payment_date', '>=', $startDate)->where('payment_date', '<=', $endDate);
        }
        
        $billCount = $billQuery->count();
        $paymentCount = $paymentQuery->count();
        
        // Get total funding amounts - these are usually fixed, so no date filter
        $fundingStats = Funding::select(
            DB::raw('SUM(approved_amt) as total_approved'),
            DB::raw('SUM(central_share) as total_central'),
            DB::raw('SUM(state_share) as total_state')
        )->first();
        
        // Get released and utilized amounts - apply time filters
        $releasedQuery = Release::query();
        $utilizedQuery = Payment::where('payment_status', 'completed');
        
        if ($startDate) {
            $releasedQuery->where('release_date', '>=', $startDate)->where('release_date', '<=', $endDate);
            $utilizedQuery->where('payment_date', '>=', $startDate)->where('payment_date', '<=', $endDate);
        }
        
        $releasedAmount = $releasedQuery->sum('release_amt');
        $utilizedAmount = $utilizedQuery->sum('payment_amt');
        
        // Get college funding utilization data for the table
        $collegeUtilizationQuery = College::select(
                'colleges.*',
                'fundings.approved_amt',
                'fundings.central_share',
                'fundings.state_share',
                'fundings.funding_id'
            )
            ->leftJoin('fundings', 'colleges.college_id', '=', 'fundings.college_id');
            
        // Apply the date filters to the subqueries for released and utilized amounts
        if ($startDate) {
            $releasedSubquery = "(SELECT SUM(release_amt) FROM releases 
                WHERE releases.funding_id = fundings.funding_id 
                AND release_date >= '{$startDate}' AND release_date <= '{$endDate}')";
                
            $utilizedSubquery = "(SELECT SUM(payment_amt) FROM payments 
                JOIN bills ON payments.bill_id = bills.bill_id 
                WHERE bills.college_id = colleges.college_id 
                AND payments.payment_status = 'completed'
                AND payment_date >= '{$startDate}' AND payment_date <= '{$endDate}')";
        } else {
            $releasedSubquery = "(SELECT SUM(release_amt) FROM releases 
                WHERE releases.funding_id = fundings.funding_id)";
                
            $utilizedSubquery = "(SELECT SUM(payment_amt) FROM payments 
                JOIN bills ON payments.bill_id = bills.bill_id 
                WHERE bills.college_id = colleges.college_id 
                AND payments.payment_status = 'completed')";
        }
        
        $collegeUtilizationQuery->addSelect(DB::raw("$releasedSubquery as released_amount"));
        $collegeUtilizationQuery->addSelect(DB::raw("$utilizedSubquery as utilized_amount"));
        
        // Calculate percentages
        $collegeUtilizationQuery->addSelect(DB::raw("(CASE 
                WHEN fundings.approved_amt > 0 
                THEN ROUND($releasedSubquery / fundings.approved_amt * 100, 2) 
                ELSE 0 
                END) as release_percent"));
                
        $collegeUtilizationQuery->addSelect(DB::raw("(CASE 
                WHEN fundings.approved_amt > 0 
                THEN ROUND($utilizedSubquery / fundings.approved_amt * 100, 2) 
                ELSE 0 
                END) as utilization_percent"));
                
        $collegeUtilization = $collegeUtilizationQuery
            ->groupBy('colleges.college_id', 'fundings.funding_id', 'fundings.approved_amt', 'fundings.central_share', 'fundings.state_share')
            ->orderBy('colleges.college_name')
            ->get();
        
        // Get recent bills for monitoring - apply time filter
        $recentBillsQuery = Bill::with(['college', 'user']);
        if ($startDate) {
            $recentBillsQuery->where('bill_date', '>=', $startDate)->where('bill_date', '<=', $endDate);
        }
        $recentBills = $recentBillsQuery->orderBy('created_at', 'desc')->limit(5)->get();
        
        // Get recent payments for monitoring - apply time filter
        $recentPaymentsQuery = Payment::with(['bill.college']);
        if ($startDate) {
            $recentPaymentsQuery->where('payment_date', '>=', $startDate)->where('payment_date', '<=', $endDate);
        }
        $recentPayments = $recentPaymentsQuery->orderBy('created_at', 'desc')->limit(5)->get();
        
        // Get funding distribution by college type - fixed data, no time filter
        $fundingByType = College::select('type', DB::raw('COUNT(*) as count'), DB::raw('SUM(fundings.approved_amt) as total_funding'))
            ->leftJoin('fundings', 'colleges.college_id', '=', 'fundings.college_id')
            ->groupBy('type')
            ->get();
        
        // Get physical progress summary - apply time filter
        $progressSummaryQuery = PhysicalProgress::select('progress_status', DB::raw('COUNT(*) as count'));
        if ($startDate) {
            $progressSummaryQuery->where('report_date', '>=', $startDate)->where('report_date', '<=', $endDate);
        }
        $progressSummary = $progressSummaryQuery->groupBy('progress_status')
            ->get()
            ->pluck('count', 'progress_status')
            ->toArray();
        
        return view('rusa.dashboard', compact(
            'collegeCount',
            'billCount',
            'paymentCount',
            'fundingStats',
            'releasedAmount',
            'utilizedAmount',
            'collegeUtilization',
            'recentBills',
            'recentPayments',
            'fundingByType',
            'progressSummary',
            'period'
        ));
    }
    
    /**
     * Display fund utilization details for all colleges
     * 
     * @return \Illuminate\View\View
     */
    public function fundUtilization()
    {
        $colleges = College::with(['fundings'])
            ->select('colleges.*')
            ->selectRaw('(SELECT SUM(release_amt) FROM releases 
                        JOIN fundings ON releases.funding_id = fundings.funding_id 
                        WHERE fundings.college_id = colleges.college_id) as released_amount')
            ->selectRaw('(SELECT SUM(payment_amt) FROM payments 
                        JOIN bills ON payments.bill_id = bills.bill_id 
                        WHERE bills.college_id = colleges.college_id 
                        AND payments.payment_status = "completed") as utilized_amount')
            ->orderBy('college_name')
            ->get();
        
        return view('rusa.utilization', compact('colleges'));
    }
    
    /**
     * Display all progress reports from colleges
     * 
     * @return \Illuminate\View\View
     */
    public function progressReports()
    {
        $progressReports = PhysicalProgress::with(['college', 'workCategory'])
            ->orderBy('report_date', 'desc')
            ->paginate(15);
        
        return view('rusa.progress', compact('progressReports'));
    }
} 