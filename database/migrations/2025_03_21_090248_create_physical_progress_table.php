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
        Schema::create('physical_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->foreignId('college_id')->constrained('colleges', 'college_id')->onDelete('cascade');
            $table->foreignId('funding_id')->constrained('fundings', 'funding_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('work_categories', 'category_id')->onDelete('cascade');
            $table->date('report_date');
            $table->decimal('completion_percent', 5, 2)->default(0)->comment('Percentage of completion');
            $table->enum('progress_status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->text('description')->nullable();
            $table->string('reported_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->date('verification_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_progress');
    }
};
