<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bill_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->foreignId('bill_id')->constrained('bills', 'bill_id')->onDelete('cascade');
            $table->foreignId('college_id')->constrained('colleges', 'college_id')->onDelete('cascade');
            $table->decimal('completion_percent', 5, 2)->default(0.00);
            $table->foreignId('category_id')->nullable()->constrained('work_categories', 'category_id')->onDelete('set null');
            $table->enum('progress_status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_progress');
    }
};
