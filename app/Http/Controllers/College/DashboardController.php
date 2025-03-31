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
                DB::raw('(SELECT SUM(bill_amt) FROM bills WHERE college_id = '.$collegeId.' AND bill_status IN ("approved", "paid")) as utilized_funding')
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
        
        // Get detailed funding breakdown by source
        $fundingBreakdown = Funding::where('college_id', $collegeId)
            ->get()
            ->map(function ($funding) {
                // Calculate utilized amount for this specific funding
                $utilizedAmount = Bill::where('funding_id', $funding->funding_id)
                    ->whereIn('bill_status', ['approved', 'paid'])
                    ->sum('bill_amt');
                
                // Calculate released amount for this funding
                $releasedAmount = DB::table('releases')
                    ->where('funding_id', $funding->funding_id)
                    ->sum('release_amt');
                
                // Calculate utilization percentage
                $utilizationPercent = 0;
                if ($releasedAmount > 0) {
                    $utilizationPercent = round(($utilizedAmount / $releasedAmount) * 100, 2);
                }
                
                // Calculate release percentage
                $releasePercent = 0;
                if ($funding->approved_amt > 0) {
                    $releasePercent = round(($releasedAmount / $funding->approved_amt) * 100, 2);
                }
                
                return [
                    'funding_id' => $funding->funding_id,
                    'funding_name' => $funding->funding_name,
                    'approved_amt' => $funding->approved_amt,
                    'released_amt' => $releasedAmount,
                    'utilized_amt' => $utilizedAmount,
                    'release_percent' => $releasePercent,
                    'utilization_percent' => $utilizationPercent,
                    'utilization_status' => $funding->utilization_status,
                    'remaining_amt' => $releasedAmount - $utilizedAmount,
                ];
            });
        
        // Get monthly utilization data for charts (last 6 months)
        $monthlyUtilization = Bill::where('college_id', $collegeId)
            ->whereIn('bill_status', ['approved', 'paid'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(bill_amt) as amount')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->pluck('amount', 'month')
            ->toArray();
        
        // Fill in missing months with zero values
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $monthKey = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $data[] = $monthlyUtilization[$monthKey] ?? 0;
        }
        
        $utilizationChartData = [
            'labels' => $labels,
            'data' => $data
        ];
        
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
            'fundingReleasePercent',
            'fundingBreakdown',
            'utilizationChartData'
        ));
    }
    
    /**
     * Display detailed fund utilization statistics
     * 
     * @return \Illuminate\View\View
     */
    public function fundUtilization()
    {
        $collegeId = Auth::user()->college_id;
        
        // Get funding information
        $fundingInfo = Funding::where('college_id', $collegeId)
            ->select(
                DB::raw('SUM(approved_amt) as total_funding'),
                DB::raw('(SELECT SUM(bill_amt) FROM bills WHERE college_id = '.$collegeId.' AND bill_status IN ("approved", "paid")) as utilized_funding')
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
        
        // Get detailed funding breakdown by source
        $fundingBreakdown = Funding::where('college_id', $collegeId)
            ->get()
            ->map(function ($funding) {
                // Calculate utilized amount for this specific funding
                $utilizedAmount = Bill::where('funding_id', $funding->funding_id)
                    ->whereIn('bill_status', ['approved', 'paid'])
                    ->sum('bill_amt');
                
                // Calculate released amount for this funding
                $releasedAmount = DB::table('releases')
                    ->where('funding_id', $funding->funding_id)
                    ->sum('release_amt');
                
                // Calculate utilization percentage
                $utilizationPercent = 0;
                if ($releasedAmount > 0) {
                    $utilizationPercent = round(($utilizedAmount / $releasedAmount) * 100, 2);
                }
                
                // Calculate release percentage
                $releasePercent = 0;
                if ($funding->approved_amt > 0) {
                    $releasePercent = round(($releasedAmount / $funding->approved_amt) * 100, 2);
                }
                
                // Since funding_type doesn't exist, use another way to categorize funding
                // For now, we'll use MDC funding, Professional funding, etc. based on naming convention
                $fundingType = 'General';
                
                // Try to determine funding type from the funding name
                if (stripos($funding->funding_name, 'MDC') !== false) {
                    $fundingType = 'MDC';
                } elseif (stripos($funding->funding_name, 'Professional') !== false) {
                    $fundingType = 'Professional';
                } elseif (stripos($funding->funding_name, 'Infrastructure') !== false) {
                    $fundingType = 'Infrastructure';
                } elseif (stripos($funding->funding_name, 'Research') !== false) {
                    $fundingType = 'Research';
                }
                
                return [
                    'funding_id' => $funding->funding_id,
                    'funding_name' => $funding->funding_name,
                    'funding_type' => $fundingType, // Use derived funding type
                    'approved_amt' => $funding->approved_amt,
                    'released_amt' => $releasedAmount,
                    'utilized_amt' => $utilizedAmount,
                    'release_percent' => $releasePercent,
                    'utilization_percent' => $utilizationPercent,
                    'utilization_status' => $funding->utilization_status,
                    'remaining_amt' => $releasedAmount - $utilizedAmount,
                    'approval_date' => $funding->approval_date,
                ];
            });
        
        // Get monthly utilization data for charts (last 12 months)
        $monthlyUtilization = Bill::where('college_id', $collegeId)
            ->whereIn('bill_status', ['approved', 'paid'])
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(bill_amt) as amount')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->pluck('amount', 'month')
            ->toArray();
        
        // Fill in missing months with zero values
        $labels = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $monthKey = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $data[] = $monthlyUtilization[$monthKey] ?? 0;
        }
        
        $utilizationChartData = [
            'labels' => $labels,
            'data' => $data
        ];
        
        // Get funding distribution by source instead of type
        // Group by funding_id and use the funding name instead
        $fundingTypeData = collect($fundingBreakdown)
            ->groupBy('funding_type')
            ->map(function ($group) {
                return [
                    'funding_type' => $group->first()['funding_type'],
                    'count' => $group->count(),
                    'total_amount' => $group->sum('approved_amt')
                ];
            })
            ->values();
        
        // Get bill data for detailed bill table
        $bills = Bill::where('college_id', $collegeId)
            ->whereIn('bill_status', ['approved', 'paid'])
            ->with(['funding'])
            ->orderBy('bill_date', 'desc')
            ->get();
        
        // Get quarterly utilization data
        $quarterlyData = [];
        $currentYear = date('Y');
        
        for ($year = $currentYear - 1; $year <= $currentYear; $year++) {
            for ($quarter = 1; $quarter <= 4; $quarter++) {
                // Set start and end dates for the quarter
                $startMonth = ($quarter - 1) * 3 + 1;
                $endMonth = $quarter * 3;
                
                $startDate = "{$year}-" . str_pad($startMonth, 2, '0', STR_PAD_LEFT) . "-01";
                $endDate = date('Y-m-t', strtotime("{$year}-" . str_pad($endMonth, 2, '0', STR_PAD_LEFT) . "-01"));
                
                // Calculate utilization for this quarter
                $quarterUtilization = Bill::where('college_id', $collegeId)
                    ->whereIn('bill_status', ['approved', 'paid'])
                    ->whereBetween('bill_date', [$startDate, $endDate])
                    ->sum('bill_amt');
                
                $quarterlyData[] = [
                    'period' => "Q{$quarter} {$year}",
                    'amount' => $quarterUtilization,
                ];
            }
        }
        
        return view('college.utilization', compact(
            'totalFunding',
            'releasedFunding',
            'utilizedFunding',
            'fundingUtilizationPercent',
            'fundingReleasePercent',
            'fundingBreakdown',
            'utilizationChartData',
            'fundingTypeData',
            'bills',
            'quarterlyData'
        ));
    }
} 