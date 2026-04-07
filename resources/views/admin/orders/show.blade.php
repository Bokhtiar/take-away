@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('admin-content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <x-ui.page-header title="Order #{{ $order->id }}" description="Review order items and update status." />
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <i class="ri-arrow-left-line"></i> All orders
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <p class="text-xs uppercase text-gray-500">Customer</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $order->customer_name }}</p>
                <p class="text-sm text-gray-500">{{ $order->customer_phone }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <p class="text-xs uppercase text-gray-500">Order Status</p>
                <p class="font-semibold capitalize text-gray-900 dark:text-white">{{ $order->order_status }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <p class="text-xs uppercase text-gray-500">Payment</p>
                <p class="font-semibold capitalize text-gray-900 dark:text-white">{{ $order->payment_status }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <p class="text-xs uppercase text-gray-500">Total</p>
                <p class="font-semibold text-gray-900 dark:text-white">${{ number_format((float) $order->total_amount, 2) }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5">
            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                @method('PUT')
                <x-ui.select name="order_status" label="Order Status" :options="[
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'preparing' => 'Preparing',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ]" :value="old('order_status', $order->order_status)" required />

                <x-ui.select name="payment_status" label="Payment Status" :options="[
                    'unpaid' => 'Unpaid',
                    'paid' => 'Paid',
                    'refunded' => 'Refunded',
                ]" :value="old('payment_status', $order->payment_status)" required />

                <div class="flex items-end">
                    <x-ui.button type="submit" variant="primary">Update Order</x-ui.button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-left">Qty</th>
                        <th class="px-6 py-3 text-left">Unit Price</th>
                        <th class="px-6 py-3 text-left">Addons</th>
                        <th class="px-6 py-3 text-left">Line Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($order->items as $item)
                        @php
                            $lineTotal = ((float) $item->price) * (int) $item->quantity;
                        @endphp
                        <tr>
                            <td class="px-6 py-4">{{ $item->product?->name ?? 'Product' }}</td>
                            <td class="px-6 py-4">{{ $item->quantity }}</td>
                            <td class="px-6 py-4">${{ number_format((float) $item->price, 2) }}</td>
                            <td class="px-6 py-4">
                                @if ($item->addons->isEmpty())
                                    <span class="text-gray-500">No addons</span>
                                @else
                                    {{ $item->addons->map(fn($addon) => ($addon->addon?->name ?? 'Addon') . ' ($' . number_format((float) $addon->price, 2) . ')')->implode(', ') }}
                                @endif
                            </td>
                            <td class="px-6 py-4">${{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

