<?php

namespace App\Http\Controllers\RUSA;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\College;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PhysicalProgress;

class RUSAController extends Controller
{
    /**
     * Display filtered bills for RUSA monitoring
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function bills(Request $request)
    {
        $query = Bill::with(['college', 'user', 'funding'])
            ->orderBy('created_at', 'desc');
        
        // Apply filters if they exist
        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }
        
        if ($request->filled('status')) {
            $query->where('bill_status', $request->status);
        }
        
        if ($request->filled('from_date')) {
            $query->where('bill_date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->where('bill_date', '<=', $request->to_date);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('bill_no', 'like', "%{$search}%")
                  ->orWhere('bill_amt', 'like', "%{$search}%")
                  ->orWhereHas('college', function($q2) use ($search) {
                      $q2->where('college_name', 'like', "%{$search}%");
                  });
            });
        }
        
        $bills = $query->paginate(15)->withQueryString();
        
        return view('rusa.bills', compact('bills'));
    }
    
    /**
     * Display filtered payments for RUSA monitoring
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function payments(Request $request)
    {
        $query = Payment::with(['bill.college'])
            ->orderBy('created_at', 'desc');
            
        // Apply filters if they exist
        if ($request->filled('college_id')) {
            $query->whereHas('bill', function($q) use ($request) {
                $q->where('college_id', $request->college_id);
            });
        }
        
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        if ($request->filled('from_date')) {
            $query->where('payment_date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->where('payment_date', '<=', $request->to_date);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_amt', 'like', "%{$search}%")
                  ->orWhere('transaction_reference', 'like', "%{$search}%")
                  ->orWhereHas('bill', function($q2) use ($search) {
                      $q2->where('bill_no', 'like', "%{$search}%")
                        ->orWhereHas('college', function($q3) use ($search) {
                            $q3->where('college_name', 'like', "%{$search}%");
                        });
                  });
            });
        }
        
        $payments = $query->paginate(15)->withQueryString();
        
        return view('rusa.payments', compact('payments'));
    }
    
    /**
     * Display filtered colleges for RUSA monitoring
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function colleges(Request $request)
    {
        $query = College::orderBy('college_name');
        
        // Apply filters if they exist
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('phase')) {
            $query->where('phase', $request->phase);
        }
        
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }
        
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('college_name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('phase', 'like', "%{$search}%")
                  ->orWhere('state', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%");
            });
        }
        
        $colleges = $query->paginate(15)->withQueryString();
        
        // Get unique values for filter dropdowns
        $types = College::distinct()->pluck('type')->filter();
        $phases = College::distinct()->pluck('phase')->filter();
        $states = College::distinct()->pluck('state')->filter();
        $districts = College::distinct()->pluck('district')->filter();
        
        return view('rusa.colleges', compact('colleges', 'types', 'phases', 'states', 'districts'));
    }

    /**
     * Display detailed information for a specific college
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function collegeDetails(string $id)
    {
        // Get college with related information
        $college = College::with(['fundings', 'physicalProgress', 'users'])
            ->findOrFail($id);
            
        // Get funding statistics
        $fundingStats = [
            'total_approved' => 0,
            'total_released' => 0,
            'total_utilized' => 0,
            'release_percent' => 0,
            'utilization_percent' => 0
        ];
        
        foreach ($college->fundings as $funding) {
            $fundingStats['total_approved'] += $funding->approved_amt;
            
            // Calculate released amount
            $releasedAmount = DB::table('releases')
                ->where('funding_id', $funding->funding_id)
                ->sum('release_amt');
                
            $fundingStats['total_released'] += $releasedAmount;
            
            // Calculate utilized amount
            $utilizedAmount = Bill::where('funding_id', $funding->funding_id)
                ->whereIn('bill_status', ['approved', 'paid'])
                ->sum('bill_amt');
                
            $fundingStats['total_utilized'] += $utilizedAmount;
        }
        
        // Calculate percentages
        if ($fundingStats['total_approved'] > 0) {
            $fundingStats['release_percent'] = round(($fundingStats['total_released'] / $fundingStats['total_approved']) * 100, 2);
            $fundingStats['utilization_percent'] = round(($fundingStats['total_utilized'] / $fundingStats['total_approved']) * 100, 2);
        }
        
        // Get recent bills
        $recentBills = Bill::where('college_id', $id)
            ->orderBy('bill_date', 'desc')
            ->limit(5)
            ->get();
            
        // Get recent physical progress reports
        $progressReports = PhysicalProgress::where('college_id', $id)
            ->orderBy('report_date', 'desc')
            ->limit(5)
            ->get();
            
        return view('rusa.college-details', compact('college', 'fundingStats', 'recentBills', 'progressReports'));
    }

    /**
     * Print detailed information for a specific college
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function printCollegeDetails(string $id)
    {
        // Get college with related information
        $college = College::with(['fundings', 'physicalProgress', 'users'])
            ->findOrFail($id);
            
        // Get funding statistics
        $fundingStats = [
            'total_approved' => 0,
            'total_released' => 0,
            'total_utilized' => 0,
            'release_percent' => 0,
            'utilization_percent' => 0
        ];
        
        foreach ($college->fundings as $funding) {
            $fundingStats['total_approved'] += $funding->approved_amt;
            
            // Calculate released amount
            $releasedAmount = DB::table('releases')
                ->where('funding_id', $funding->funding_id)
                ->sum('release_amt');
                
            $fundingStats['total_released'] += $releasedAmount;
            
            // Calculate utilized amount
            $utilizedAmount = Bill::where('funding_id', $funding->funding_id)
                ->whereIn('bill_status', ['approved', 'paid'])
                ->sum('bill_amt');
                
            $fundingStats['total_utilized'] += $utilizedAmount;
        }
        
        // Calculate percentages
        if ($fundingStats['total_approved'] > 0) {
            $fundingStats['release_percent'] = round(($fundingStats['total_released'] / $fundingStats['total_approved']) * 100, 2);
            $fundingStats['utilization_percent'] = round(($fundingStats['total_utilized'] / $fundingStats['total_approved']) * 100, 2);
        }
        
        // Get all bills (not just recent ones)
        $bills = Bill::where('college_id', $id)
            ->orderBy('bill_date', 'desc')
            ->get();
            
        // Get all physical progress reports (not just recent ones)
        $progressReports = PhysicalProgress::where('college_id', $id)
            ->orderBy('report_date', 'desc')
            ->get();
            
        return view('rusa.college-details-print', compact('college', 'fundingStats', 'bills', 'progressReports'));
    }
} 