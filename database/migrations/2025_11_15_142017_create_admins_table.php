<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            // basic information of admin
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            // this role_id for menu permissions
            $table->integer('role_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // Add spatial POINT column (NOT NULL for spatial index)
        DB::statement('ALTER TABLE admins ADD location POINT NOT NULL');
        // Add spatial index
        DB::statement('ALTER TABLE admins ADD SPATIAL INDEX location_index (location)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex('location_index');
        });
        
        DB::statement('ALTER TABLE admins DROP COLUMN location');
        
        Schema::dropIfExists('admins');
    }
};
