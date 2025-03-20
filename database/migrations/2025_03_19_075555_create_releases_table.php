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
        Schema::create('releases', function (Blueprint $table) {
            $table->id('release_id');
            $table->decimal('release_amt', 10, 2)->comment('Amount released in crores');
            $table->date('release_date');
            $table->foreignId('funding_id')->constrained('fundings', 'funding_id')->onDelete('cascade');
            $table->text('desc')->comment('Description of the release');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releases');
    }
};
