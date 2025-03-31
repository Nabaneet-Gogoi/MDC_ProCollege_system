<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Admin middleware is applied in route definition
    }

    /**
     * Display a listing of the colleges.
     */
    public function index()
    {
        $colleges = College::orderBy('college_id')->paginate(10);
        return view('admin.colleges.index', compact('colleges'));
    }

    /**
     * Show the form for creating a new college.
     */
    public function create()
    {
        $typeOptions = College::getTypeOptions();
        $phaseOptions = College::getPhaseOptions();
        
        return view('admin.colleges.create', compact('typeOptions', 'phaseOptions'));
    }

    /**
     * Store a newly created college in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'college_name' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'type' => 'required|in:professional,MDC',
            'phase' => 'required_if:type,MDC|nullable|in:1,2',
        ]);

        if ($request->type === 'professional') {
            $validated['phase'] = null;
        }

        $college = College::create($validated);
        
        // Log the creation action
        AuditLogService::logCreation(
            $college,
            "Created college: {$college->college_name}"
        );

        return redirect()
            ->route('admin.colleges.index')
            ->with('success', 'College added successfully.');
    }

    /**
     * Display the specified college.
     */
    public function show(College $college)
    {
        return view('admin.colleges.show', compact('college'));
    }

    /**
     * Show the form for editing the specified college.
     */
    public function edit(College $college)
    {
        $typeOptions = College::getTypeOptions();
        $phaseOptions = College::getPhaseOptions();
        
        return view('admin.colleges.edit', compact('college', 'typeOptions', 'phaseOptions'));
    }

    /**
     * Update the specified college in storage.
     */
    public function update(Request $request, College $college)
    {
        $validated = $request->validate([
            'college_name' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'type' => 'required|in:professional,MDC',
            'phase' => 'required_if:type,MDC|nullable|in:1,2',
        ]);

        if ($request->type === 'professional') {
            $validated['phase'] = null;
        }
        
        // Store old values before update
        $oldValues = $college->toArray();
        
        $college->update($validated);
        
        // Log the update action
        AuditLogService::logUpdate(
            $college,
            $oldValues,
            "Updated college: {$college->college_name}"
        );

        return redirect()
            ->route('admin.colleges.index')
            ->with('success', 'College updated successfully.');
    }

    /**
     * Remove the specified college from storage.
     */
    public function destroy(College $college)
    {
        // Store college data before deletion
        $collegeName = $college->college_name;
        $collegeData = $college->toArray();
        
        $college->delete();
        
        // Log the deletion action
        AuditLogService::logDeletion(
            $college,
            "Deleted college: {$collegeName}"
        );
        
        return redirect()
            ->route('admin.colleges.index')
            ->with('success', 'College deleted successfully.');
    }
}
