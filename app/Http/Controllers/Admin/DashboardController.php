<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\College;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalColleges' => College::count(),
            'professionalColleges' => College::where('type', 'professional')->count(),
            'mdcColleges' => College::where('type', 'MDC')->count(),
            'totalAdmins' => Admin::count(),
            'recentActivities' => $this->getRecentActivities(),
        ];

        return view('admin.dashboard', $data);
    }

    private function getRecentActivities()
    {
        // This is a placeholder. You can implement actual activity logging later
        return collect([
            [
                'icon' => 'C',
                'description' => 'New college added: Engineering College',
                'created_at' => now()->subHours(2)->diffForHumans(),
            ],
            [
                'icon' => 'A',
                'description' => 'New admin account created',
                'created_at' => now()->subHours(5)->diffForHumans(),
            ],
            [
                'icon' => 'U',
                'description' => 'System settings updated',
                'created_at' => now()->subDays(1)->diffForHumans(),
            ],
        ]);
    }
} 