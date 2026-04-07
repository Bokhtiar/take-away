@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@php
    $orderStatuses = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'preparing' => 'Preparing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
    $paymentStatuses = [
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
        'refunded' => 'Refunded',
    ];
@endphp

@section('admin-content')
    <div
        class="space-y-6"
        x-data="{
            orderStatus: @js($order->order_status),
            paymentStatus: @js($order->payment_status),
            saving: false,
            async save() {
                this.saving = true;
                try {
                    const res = await fetch(@js(route('admin.orders.update', $order->id)), {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            order_status: this.orderStatus,
                            payment_status: this.paymentStatus,
                        }),
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) {
                        const err = data.errors?.order_status?.[0] || data.errors?.payment_status?.[0] || data.message || 'Update failed';
                        throw new Error(err);
                    }
                    this.orderStatus = data.order_status ?? this.orderStatus;
                    this.paymentStatus = data.payment_status ?? this.paymentStatus;
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: data.message || 'Order updated successfully.',
                            duration: 2500,
                            gravity: 'top',
                            position: 'right',
                            style: { background: 'linear-gradient(to right, #10b981, #059669)' },
                        }).showToast();
                    }
                } catch (e) {
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: e.message || 'Could not update order.',
                            duration: 3000,
                            gravity: 'top',
                            position: 'right',
                            style: { background: 'linear-gradient(to right, #ef4444, #dc2626)' },
                        }).showToast();
                    }
                } finally {
                    this.saving = false;
                }
            },
        }"
    >
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <x-ui.page-header title="Order #{{ $order->id }}" description="Tap a status to save immediately." />
            <a href="{{ route('admin.orders.today') }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <i class="ri-arrow-left-line"></i> Orders
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
                <p class="font-semibold capitalize text-gray-900 dark:text-white" x-text="orderStatus"></p>
            </div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <p class="text-xs uppercase text-gray-500">Payment</p>
                <p class="font-semibold capitalize text-gray-900 dark:text-white" x-text="paymentStatus"></p>
            </div>
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <p class="text-xs uppercase text-gray-500">Total</p>
                <p class="font-semibold text-gray-900 dark:text-white">${{ number_format((float) $order->total_amount, 2) }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 space-y-6">
            <div>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Order status</p>
                <div class="inline-flex flex-wrap gap-2 p-1 rounded-xl bg-gray-100 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-600">
                    @foreach ($orderStatuses as $value => $label)
                        <button
                            type="button"
                            @click="orderStatus = '{{ $value }}'; save()"
                            :class="orderStatus === '{{ $value }}'
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-200/80 dark:hover:bg-gray-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all disabled:opacity-50"
                            :disabled="saving"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Payment status</p>
                <div class="inline-flex flex-wrap gap-2 p-1 rounded-xl bg-gray-100 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-600">
                    @foreach ($paymentStatuses as $value => $label)
                        <button
                            type="button"
                            @click="paymentStatus = '{{ $value }}'; save()"
                            :class="paymentStatus === '{{ $value }}'
                                ? 'bg-emerald-600 text-white shadow-sm'
                                : 'bg-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-200/80 dark:hover:bg-gray-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all disabled:opacity-50"
                            :disabled="saving"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400" x-show="saving" x-cloak>Saving…</p>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700/50">
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
