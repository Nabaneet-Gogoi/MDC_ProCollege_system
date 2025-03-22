<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insert default work categories
        DB::table('work_categories')->insert([
            ['category_name' => 'Main Building', 'description' => 'Main college building construction', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Hostel', 'description' => 'Student hostel construction', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Administrative Block', 'description' => 'Administrative offices construction', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Medical Facilities', 'description' => 'Medical facilities and infrastructure', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_categories');
    }
};
