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
        Schema::create('fundings', function (Blueprint $table) {
            $table->id('funding_id');
            $table->foreignId('college_id')->constrained('colleges', 'college_id');
            $table->string('funding_name')->comment('Name of the funding');
            $table->decimal('approved_amt', 10, 2)->comment('Total approved amount in crores');
            $table->decimal('central_share', 10, 2)->comment('Central government share amount');
            $table->decimal('state_share', 10, 2)->comment('State government share amount');
            $table->enum('utilization_status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundings');
    }
};
