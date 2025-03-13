<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates a users table with fields:
     * - user_id: primary key
     * - username: unique username for login
     * - password: hashed password
     * - role: enum for 'college' or 'RUSA' user types
     * - college_id: foreign key to colleges table (nullable for RUSA users)
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['college', 'RUSA']);
            $table->unsignedBigInteger('college_id')->nullable();
            $table->foreign('college_id')->references('college_id')->on('colleges')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
