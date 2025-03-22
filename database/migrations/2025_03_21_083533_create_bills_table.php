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
        Schema::create('bills', function (Blueprint $table) {
            $table->id('bill_id');
            $table->foreignId('college_id')->constrained('colleges', 'college_id')->onDelete('cascade');
            $table->foreignId('funding_id')->constrained('fundings', 'funding_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('bill_no')->unique();
            $table->decimal('bill_amt', 10, 2)->comment('Bill amount in crores');
            $table->date('bill_date');
            $table->enum('bill_status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->text('description')->nullable();
            $table->text('admin_remarks')->nullable()->comment('Admin feedback or remarks on the bill');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
