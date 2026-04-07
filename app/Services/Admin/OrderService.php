<?php

namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    public function index(
        int $perPage = 10,
        ?string $search = null,
        ?string $status = null,
        ?string $paymentStatus = null
    ): LengthAwarePaginator {
        $query = Order::query()
            ->with('user')
            ->where('soft_delete', false);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        if ($status) {
            $query->where('order_status', $status);
        }

        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }

        return $query->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): Order
    {
        return Order::query()
            ->with(['user', 'items.product', 'items.addons.addon'])
            ->where('soft_delete', false)
            ->findOrFail($id);
    }

    public function updateStatus(Order $order, array $data): Order
    {
        $order->update([
            'order_status' => $data['order_status'],
            'payment_status' => $data['payment_status'],
        ]);

        return $order->fresh();
    }

    public function softDelete(Order $order): Order
    {
        $order->update(['soft_delete' => true]);

        return $order->fresh();
    }
}

