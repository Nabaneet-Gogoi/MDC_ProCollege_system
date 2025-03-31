<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Only allow superadmin access
        if (auth()->guard('admin')->user()->role !== 'superadmin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to view audit logs.');
        }
        
        $query = AuditLog::with('admin')
            ->orderBy('created_at', 'desc');
        
        // Filter by admin
        if ($request->has('admin_id') && $request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }
        
        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }
        
        // Filter by model type
        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', 'like', '%' . $request->model_type . '%');
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $auditLogs = $query->paginate(15)->withQueryString();
        $admins = Admin::orderBy('name')->get();
        $actions = AuditLog::select('action')->distinct()->pluck('action');
        
        return view('admin.audit-logs.index', compact('auditLogs', 'admins', 'actions'));
    }
    
    /**
     * Display the specified audit log.
     *
     * @param  \App\Models\AuditLog  $auditLog
     * @return \Illuminate\View\View
     */
    public function show(AuditLog $auditLog)
    {
        // Only allow superadmin access
        if (auth()->guard('admin')->user()->role !== 'superadmin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to view audit logs.');
        }
        
        return view('admin.audit-logs.show', compact('auditLog'));
    }
}
