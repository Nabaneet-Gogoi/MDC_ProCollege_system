<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $admins = Admin::paginate(10);
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
        return view('admin.dashboard');
    }
}
