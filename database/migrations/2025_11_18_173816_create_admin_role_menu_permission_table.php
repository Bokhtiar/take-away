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
        Schema::create('admin_role_menu_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_permission_id');
            $table->boolean('allow')->default(true);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('role_id')->references('id')->on('admin_roles')->onDelete('cascade');
            $table->foreign('menu_permission_id')->references('id')->on('admin_menu_permission')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate role-menu-permission pairs
            $table->unique(['role_id', 'menu_permission_id']);
            
            // Indexes
            $table->index('role_id');
            $table->index('menu_permission_id');
            $table->index('allow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_role_menu_permission');
    }
};
