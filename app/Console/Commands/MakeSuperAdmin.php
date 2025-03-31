<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Services\AuditLogService;
use Illuminate\Console\Command;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make-superadmin {email : The email of the admin to promote to superadmin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote an existing admin to superadmin role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $admin = Admin::where('email', $email)->first();
        
        if (!$admin) {
            $this->error("Admin with email {$email} not found.");
            return 1;
        }
        
        if ($admin->role === 'superadmin') {
            $this->info("Admin {$email} is already a superadmin.");
            return 0;
        }
        
        // Store old values for audit log
        $oldValues = $admin->toArray();
        
        // Update the admin role to superadmin
        $admin->role = 'superadmin';
        $admin->save();
        
        // Log the action
        AuditLogService::logUpdate(
            $admin,
            $oldValues,
            "Admin {$admin->email} promoted to superadmin"
        );
        
        $this->info("Admin {$email} has been promoted to superadmin successfully.");
        
        return 0;
    }
}
