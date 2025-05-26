<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Release;
use App\Models\Funding;
use App\Models\College;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Release::with(['funding', 'funding.college']);

        // Filter by college_id
        if ($request->filled('college_id')) {
            $query->whereHas('funding.college', function ($q) use ($request) {
                $q->where('college_id', $request->input('college_id'));
            });
        }

        // Filter by release date from
        if ($request->filled('date_from')) {
            $query->whereDate('release_date', '>=', $request->input('date_from'));
        }

        // Filter by release date to
        if ($request->filled('date_to')) {
            $query->whereDate('release_date', '<=', $request->input('date_to'));
        }

        // Filter by min amount
        if ($request->filled('min_amount')) {
            $query->where('release_amt', '>=', $request->input('min_amount'));
        }

        // Filter by max amount
        if ($request->filled('max_amount')) {
            $query->where('release_amt', '<=', $request->input('max_amount'));
        }
        
        // Filter by utilization status
        if ($request->filled('utilization_status')) {
            $statusRange = explode('-', $request->input('utilization_status'));
            $query->whereHas('funding', function ($q) use ($statusRange) {
                if (count($statusRange) == 2) {
                    $q->where('utilization_percentage', '>=', $statusRange[0])
                      ->where('utilization_percentage', '<=', $statusRange[1]);
                } elseif ($statusRange[0] == '100') {
                    $q->where('utilization_percentage', '>=', 100);
                } 
            });
        }

        $releases = $query->latest()->paginate(10)->withQueryString();
        return view('admin.releases.index', compact('releases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get fundings that are in progress or not started and have remaining balance
        $fundings = Funding::with('college')
            ->whereIn('utilization_status', ['not_started', 'in_progress'])
            ->get()
            ->filter(function ($funding) {
                return $funding->remaining_balance > 0;
            });
        
        return view('admin.releases.create', compact('fundings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'funding_id' => 'required|exists:fundings,funding_id',
            'release_amt' => 'required|numeric|min:0.01',
            'release_date' => 'required|date',
            'desc' => 'required|string|max:1000',
        ]);
        
        // Check if release amount is within the remaining balance
        $funding = Funding::findOrFail($validated['funding_id']);
        if ($validated['release_amt'] > $funding->remaining_balance) {
            return back()->withInput()->withErrors([
                'release_amt' => 'Release amount cannot exceed the remaining balance of ₹' . number_format($funding->remaining_balance, 2) . ' crores.'
            ]);
        }
        
        $release = Release::create($validated);
        
        // Update funding utilization status if needed
        $this->updateFundingStatus($funding);
        
        return redirect()->route('admin.releases.index')
            ->with('success', 'Fund release recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $release = Release::with(['funding', 'funding.college'])->findOrFail($id);
        return view('admin.releases.show', compact('release'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $release = Release::findOrFail($id);
        $fundings = Funding::with('college')->get();
        return view('admin.releases.edit', compact('release', 'fundings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $release = Release::findOrFail($id);
        $originalAmount = $release->release_amt;
        $originalFundingId = $release->funding_id;
        
        $validated = $request->validate([
            'funding_id' => 'required|exists:fundings,funding_id',
            'release_amt' => 'required|numeric|min:0.01',
            'release_date' => 'required|date',
            'desc' => 'required|string|max:1000',
        ]);
        
        // If funding changed or amount increased, check balance
        if ($validated['funding_id'] != $originalFundingId || 
            ($validated['funding_id'] == $originalFundingId && $validated['release_amt'] > $originalAmount)) {
            
            $funding = Funding::findOrFail($validated['funding_id']);
            $adjustedBalance = $funding->remaining_balance;
            
            // Add back the original amount if same funding
            if ($validated['funding_id'] == $originalFundingId) {
                $adjustedBalance += $originalAmount;
            }
            
            if ($validated['release_amt'] > $adjustedBalance) {
                return back()->withInput()->withErrors([
                    'release_amt' => 'Release amount cannot exceed the remaining balance of ₹' . number_format($adjustedBalance, 2) . ' crores.'
                ]);
            }
        }
        
        $release->update($validated);
        
        // Update statuses of both old and new funding if they changed
        if ($originalFundingId != $validated['funding_id']) {
            $this->updateFundingStatus(Funding::findOrFail($originalFundingId));
        }
        $this->updateFundingStatus(Funding::findOrFail($validated['funding_id']));
        
        return redirect()->route('admin.releases.index')
            ->with('success', 'Fund release updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $release = Release::findOrFail($id);
        $fundingId = $release->funding_id;
        
        $release->delete();
        
        // Update funding status after deletion
        $this->updateFundingStatus(Funding::findOrFail($fundingId));
        
        return redirect()->route('admin.releases.index')
            ->with('success', 'Fund release deleted successfully');
    }
    
    /**
     * Get funding details for a specific funding record.
     */
    public function getFundingDetails(Request $request)
    {
        $fundingId = $request->input('funding_id');
        $funding = Funding::with('college')->findOrFail($fundingId);
        
        return response()->json([
            'college_name' => $funding->college->college_name,
            'approved_amt' => $funding->approved_amt,
            'total_released' => $funding->total_released,
            'remaining_balance' => $funding->remaining_balance,
            'utilization_percentage' => $funding->utilization_percentage
        ]);
    }
    
    /**
     * Get funding details by ID for GET requests.
     */
    public function getFundingDetailsById($id)
    {
        $funding = Funding::with('college')->findOrFail($id);
        
        return response()->json([
            'college_name' => $funding->college->college_name,
            'approved_amt' => $funding->approved_amt,
            'total_released' => $funding->total_released,
            'remaining_balance' => $funding->remaining_balance,
            'utilization_percentage' => $funding->utilization_percentage
        ]);
    }
    
    /**
     * Update funding utilization status based on releases.
     */
    private function updateFundingStatus(Funding $funding)
    {
        // Refresh to get the latest release data
        $funding->refresh();
        
        if ($funding->utilization_percentage >= 99.9) {
            $funding->update(['utilization_status' => 'completed']);
        } elseif ($funding->utilization_percentage > 0) {
            $funding->update(['utilization_status' => 'in_progress']);
        } else {
            $funding->update(['utilization_status' => 'not_started']);
        }
    }
}
