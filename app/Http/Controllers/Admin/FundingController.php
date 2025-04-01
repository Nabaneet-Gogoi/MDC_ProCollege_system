<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Funding;
use Illuminate\Support\Facades\DB;

class FundingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fundings = Funding::with('college')->get();
        return view('admin.fundings.index', compact('fundings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get colleges that don't have funding allocated yet
        $colleges = College::whereNotExists(function($query) {
            $query->select(DB::raw(1))
                  ->from('fundings')
                  ->whereRaw('fundings.college_id = colleges.college_id');
        })->get();
        
        return view('admin.fundings.create', compact('colleges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,college_id|unique:fundings,college_id',
            'funding_name' => 'required|string|max:255',
            'approved_amt' => 'required|numeric|min:0',
            'central_share' => 'required|numeric|min:0',
            'state_share' => 'required|numeric|min:0',
            'utilization_status' => 'required|in:not_started,in_progress,completed',
        ]);

        Funding::create($request->all());

        return redirect()->route('admin.fundings.index')
            ->with('success', 'Funding allocation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $funding = Funding::with('college')->findOrFail($id);
        return view('admin.fundings.show', compact('funding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $funding = Funding::findOrFail($id);
        return view('admin.fundings.edit', compact('funding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'funding_name' => 'required|string|max:255',
            'approved_amt' => 'required|numeric|min:0',
            'central_share' => 'required|numeric|min:0',
            'state_share' => 'required|numeric|min:0',
            'utilization_status' => 'required|in:not_started,in_progress,completed',
        ]);

        $funding = Funding::findOrFail($id);
        $funding->update($request->all());

        return redirect()->route('admin.fundings.index')
            ->with('success', 'Funding allocation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $funding = Funding::findOrFail($id);
        $funding->delete();

        return redirect()->route('admin.fundings.index')
            ->with('success', 'Funding allocation deleted successfully');
    }
    
    /**
     * Calculate and display the auto-calculated funding amounts for a college.
     */
    public function calculateFunding(Request $request)
    {
        \Log::info('Funding calculation request received', $request->all());
        
        try {
            $validated = $request->validate([
                'college_id' => 'required|exists:colleges,college_id',
            ]);
            
            $college = College::findOrFail($validated['college_id']);
            $fundingData = Funding::calculateFundingForCollege($college);
            
            \Log::info('Funding calculation successful', $fundingData);
            
            return response()->json($fundingData);
        } catch (\Exception $e) {
            \Log::error('Funding calculation error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to calculate funding'], 500);
        }
    }
}
