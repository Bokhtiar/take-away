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
        Schema::create('admin_menu_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('menu_id')->references('id')->on('admin_menus')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('admin_permissions')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate menu-permission pairs
            $table->unique(['menu_id', 'permission_id']);
            
            // Indexes
            $table->index('menu_id');
            $table->index('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_menu_permission');
    }
};
