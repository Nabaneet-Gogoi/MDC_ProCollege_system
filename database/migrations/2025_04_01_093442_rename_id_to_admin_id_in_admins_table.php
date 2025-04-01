<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations to rename id column to admin_id
     */
    public function up(): void
    {
        // First remove the auto_increment from id
        DB::statement('ALTER TABLE admins MODIFY id BIGINT UNSIGNED NOT NULL');
        
        // Add admin_id column
        Schema::table('admins', function (Blueprint $table) {
            $table->bigInteger('admin_id')->unsigned()->after('id');
        });
        
        // Copy data from id to admin_id
        DB::statement('UPDATE admins SET admin_id = id');
        
        // Set admin_id as primary key
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->primary('admin_id');
        });
        
        // Add auto increment to admin_id
        DB::statement('ALTER TABLE admins MODIFY admin_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove auto_increment from admin_id
        DB::statement('ALTER TABLE admins MODIFY admin_id BIGINT UNSIGNED NOT NULL');
        
        // Add id column
        Schema::table('admins', function (Blueprint $table) {
            $table->dropPrimary('admin_id');
            $table->bigInteger('id')->unsigned()->first();
        });
        
        // Copy data from admin_id to id
        DB::statement('UPDATE admins SET id = admin_id');
        
        // Set id as primary key
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('admin_id');
            $table->primary('id');
        });
        
        // Add auto_increment to id
        DB::statement('ALTER TABLE admins MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }
};
