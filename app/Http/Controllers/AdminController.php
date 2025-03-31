<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\College;
use App\Models\Bill;
use App\Models\User;
use App\Models\Funding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware is already defined in routes
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::orderBy('admin_id')->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'phone_no' => 'required|string|max:15',
        ]);

        Admin::create($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($admin->admin_id, 'admin_id')],
            'phone_no' => 'required|string|max:15',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        // Prevent deleting yourself
        if ($admin->admin_id === auth()->guard('admin')->user()->admin_id) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }
    
    /**
     * Display the dashboard.
     */
    public function dashboard()
    {
        // Get counts for dashboard stats
        $adminCount = Admin::count();
        $collegeCount = College::count();
        $userCount = User::count();
        $billCount = Bill::count();
        $pendingBillCount = Bill::where('bill_status', 'pending')->count();
        $approvedBillCount = Bill::whereIn('bill_status', ['approved', 'paid'])->count();
        
        // Get system-wide funding information
        $fundingInfo = Funding::select(
            DB::raw('SUM(approved_amt) as total_approved'),
            DB::raw('SUM(central_share) as total_central'),
            DB::raw('SUM(state_share) as total_state')
        )->first();
        
        // Get released amount
        $releasedAmount = DB::table('releases')->sum('release_amt');
        
        // Get utilized amount (approved and paid bills)
        $utilizedAmount = Bill::whereIn('bill_status', ['approved', 'paid'])->sum('bill_amt');
        
        // Calculate percentages
        $releasePercent = $fundingInfo->total_approved > 0 ? 
            round(($releasedAmount / $fundingInfo->total_approved) * 100, 2) : 0;
            
        $utilizationPercent = $releasedAmount > 0 ? 
            round(($utilizedAmount / $releasedAmount) * 100, 2) : 0;
        
        // Get college-wise utilization data
        $collegeUtilization = College::select('colleges.college_id', 'colleges.college_name', 'colleges.type')
            ->addSelect(DB::raw('SUM(fundings.approved_amt) as total_approved'))
            ->addSelect(DB::raw('(SELECT COALESCE(SUM(release_amt), 0) FROM releases JOIN fundings f ON releases.funding_id = f.funding_id WHERE f.college_id = colleges.college_id) as total_released'))
            ->addSelect(DB::raw('(SELECT COALESCE(SUM(bill_amt), 0) FROM bills WHERE bills.college_id = colleges.college_id AND bill_status IN ("approved", "paid")) as total_utilized'))
            ->join('fundings', 'colleges.college_id', '=', 'fundings.college_id')
            ->groupBy('colleges.college_id', 'colleges.college_name', 'colleges.type')
            ->get()
            ->map(function ($college) {
                $college->release_percent = $college->total_approved > 0 ? 
                    round(($college->total_released / $college->total_approved) * 100, 2) : 0;
                    
                $college->utilization_percent = $college->total_released > 0 ? 
                    round(($college->total_utilized / $college->total_released) * 100, 2) : 0;
                    
                return $college;
            });
            
        // Get monthly data for charts
        $monthlyData = Bill::whereIn('bill_status', ['approved', 'paid'])
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
            
        // Fill in missing months
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $monthKey = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $data[] = $monthlyData[$monthKey] ?? 0;
        }
        
        $chartData = [
            'labels' => $labels,
            'data' => $data
        ];
        
        // Get funding type distribution
        $fundingTypeData = Funding::select(
                DB::raw('colleges.type as funding_type'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(fundings.approved_amt) as total_amount')
            )
            ->join('colleges', 'fundings.college_id', '=', 'colleges.college_id')
            ->groupBy('colleges.type')
            ->get();
            
        return view('admin.dashboard', compact(
            'adminCount',
            'collegeCount',
            'userCount',
            'billCount',
            'pendingBillCount',
            'approvedBillCount',
            'fundingInfo',
            'releasedAmount',
            'utilizedAmount',
            'releasePercent',
            'utilizationPercent',
            'collegeUtilization',
            'chartData',
            'fundingTypeData'
        ));
    }
}
