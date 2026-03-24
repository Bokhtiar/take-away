<?php

namespace App\Services;

use App\Models\Addon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createForUser(int $userId, array $payload): Order
    {
        return DB::transaction(function () use ($userId, $payload) {
            $order = Order::create([
                'user_id' => $userId,
                'customer_name' => $payload['customer_name'],
                'customer_phone' => $payload['customer_phone'],
                'order_status' => 'pending',
                'payment_status' => 'unpaid',
                'total_amount' => 0,
                'soft_delete' => false,
            ]);

            $grandTotal = 0;

            foreach ($payload['items'] as $item) {
                $product = Product::query()->findOrFail((int) $item['product_id']);
                $basePrice = array_key_exists('base_price', $item) ? (float) $item['base_price'] : (float) $product->price;
                $qty = (int) $item['qty'];

                $orderItem = $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $basePrice,
                ]);

                $lineAddonTotal = 0;
                $addons = is_array($item['addons'] ?? null) ? $item['addons'] : [];

                foreach ($addons as $addonData) {
                    $addon = Addon::query()->findOrFail((int) $addonData['addon_id']);
                    $addonPrice = (float) $addon->price;

                    $orderItem->addons()->create([
                        'addon_id' => $addon->id,
                        'price' => $addonPrice,
                    ]);

                    $lineAddonTotal += $addonPrice;
                }

                // Keep effective per-unit price in order_items for easier reporting.
                $effectiveUnitPrice = $basePrice + $lineAddonTotal;
                $orderItem->update(['price' => $effectiveUnitPrice]);

                $grandTotal += ($effectiveUnitPrice * $qty);
            }

            $order->update(['total_amount' => $grandTotal]);

            return $order->load(['items.product', 'items.addons.addon']);
        });
    }

    public function userOrders(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::query()
            ->where('user_id', $userId)
            ->where('soft_delete', false)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function userOrderDetails(int $userId, int $orderId): Order
    {
        return Order::query()
            ->with(['items.product', 'items.addons.addon'])
            ->where('user_id', $userId)
            ->where('soft_delete', false)
            ->findOrFail($orderId);
    }
}

