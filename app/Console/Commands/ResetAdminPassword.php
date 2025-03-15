<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {email? : The email of the admin} {--password= : The new password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset an admin user\'s password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get email from argument or prompt
        $email = $this->argument('email');
        if (!$email) {
            $email = $this->ask('Enter the admin email address');
        }

        // Find the admin by email
        $admin = Admin::where('email', $email)->first();
        
        if (!$admin) {
            $this->error("No admin found with email {$email}");
            return 1;
        }

        // Get password from option or prompt
        $password = $this->option('password');
        if (!$password) {
            $password = $this->secret('Enter the new password (min 8 characters)');
            
            if (strlen($password) < 8) {
                $this->error('Password must be at least 8 characters long');
                return 1;
            }
            
            $confirmPassword = $this->secret('Confirm the new password');
            
            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match');
                return 1;
            }
        }

        // Update the password
        $admin->password = $password;
        $admin->save();

        $this->info("Password for admin {$email} has been reset successfully");
        return 0;
    }
} 