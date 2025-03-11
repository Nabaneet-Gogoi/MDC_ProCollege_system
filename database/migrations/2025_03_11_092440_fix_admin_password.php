<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all admin records
        $admins = Admin::all();
        
        foreach ($admins as $admin) {
            // Only update if the password isn't already properly hashed
            if (!password_get_info($admin->password)['algo']) {
                $admin->password = 'admin123'; // Default temporary password
                $admin->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse password hashing
    }
};
