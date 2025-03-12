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
        Schema::create('colleges', function (Blueprint $table) {
            $table->id('college_id');
            $table->string('college_name');
            $table->string('state');
            $table->string('district');
            $table->enum('type', ['professional', 'MDC'])->comment('professional or model degree colleges');
            $table->enum('phase', ['1', '2'])->comment('Phase 1 or Phase 2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
