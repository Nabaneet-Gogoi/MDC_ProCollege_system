<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\User;
use App\Models\Funding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the college profile
     */
    public function index()
    {
        $collegeId = Auth::user()->college_id;
        $college = College::with(['funding', 'users'])->findOrFail($collegeId);
        
        // Get funding information
        $fundingInfo = Funding::where('college_id', $collegeId)
            ->first();
            
        // Get released amount
        $releasedAmount = 0;
        if ($fundingInfo) {
            $releasedAmount = $fundingInfo->total_released;
        }
        
        // Get state and phase options for dropdowns
        $typeOptions = College::getTypeOptions();
        $phaseOptions = College::getPhaseOptions();
        
        return view('college.profile.index', compact('college', 'fundingInfo', 'releasedAmount', 'typeOptions', 'phaseOptions'));
    }
    
    /**
     * Update the college profile
     */
    public function update(Request $request)
    {
        $collegeId = Auth::user()->college_id;
        $college = College::findOrFail($collegeId);
        
        // Validate input
        $request->validate([
            'college_name' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
        ]);
        
        // Update college details
        $college->update([
            'college_name' => $request->college_name,
            'state' => $request->state,
            'district' => $request->district,
        ]);
        
        return redirect()->route('college.profile.index')
            ->with('success', 'College profile updated successfully.');
    }
    
    /**
     * Show the form to change account password
     */
    public function showChangePasswordForm()
    {
        return view('college.profile.change-password');
    }
    
    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // Validate input
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('college.profile.index')
            ->with('success', 'Password updated successfully.');
    }
} 