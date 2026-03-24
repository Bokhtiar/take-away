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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('order_status', 50)->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_status', 50)->default('unpaid');
            $table->boolean('soft_delete')->default(false);
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['order_status']);
            $table->index(['payment_status']);
            $table->index(['created_at']);
            $table->index(['soft_delete']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

