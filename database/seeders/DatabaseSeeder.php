<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create RUSA test user
        User::create([
            'username' => 'rusa_admin',
            'password' => Hash::make('password123'),
            'role' => 'RUSA',
            'college_id' => null, // RUSA users don't have a specific college
        ]);
        
        // Call the college seeder to populate universities and colleges
        $this->call([
            CollegeSeeder::class,
        ]);
    }
}
