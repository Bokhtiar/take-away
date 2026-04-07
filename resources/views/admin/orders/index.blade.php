@extends('admin.layouts.app')

@php
    $filterDate = $filterDate ?? null;
    $ordersFormAction = isset($filterDate) ? route('admin.orders.today') : route('admin.orders.index');
@endphp

@section('title')
    {{ isset($filterDate) ? "Today's orders" : 'All orders' }}
@endsection

@section('page-title')
    {{ isset($filterDate) ? "Today's orders" : 'All orders' }}
@endsection

@section('admin-content')
    <div class="space-y-6" x-data="{ csrf: '{{ csrf_token() }}' }">
        <x-ui.page-header
            :title="isset($filterDate) ? 'Today\'s orders' : 'All orders'"
            :description="isset($filterDate)
                ? 'Orders for the selected date (defaults to today). Change the date and apply filters as needed.'
                : 'All orders, newest first. Toggle complete (Completed / Pending) and payment (Paid / Unpaid) per row.'"
        />

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm">
            <form method="GET" action="{{ $ordersFormAction }}" class="flex flex-nowrap items-end gap-3 w-full min-w-0 overflow-x-auto pb-0.5">
                @if (isset($filterDate))
                    <div class="w-44 shrink-0">
                        <label for="filter-date" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Date</label>
                        <input
                            type="date"
                            name="date"
                            id="filter-date"
                            value="{{ $filterDate }}"
                            class="h-11 w-full px-3 text-sm border border-gray-300 rounded-xl bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500"
                        >
                    </div>
                @endif
                <div class="flex-1 min-w-[12rem] max-w-xl shrink">
                    <label for="orders-search" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Search</label>
                    <input id="orders-search" type="text" name="search" value="{{ request('search') }}" placeholder="ID, name, phone…"
                        class="h-11 w-full px-4 text-sm border border-gray-300 rounded-xl bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500">
                </div>
                <div class="w-44 shrink-0">
                    <label for="order_status" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Status</label>
                    <x-ui.select name="order_status" :options="[
                        '' => 'All Status',
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'preparing' => 'Preparing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]" :value="request('order_status')" class="h-11 rounded-xl py-0" />
                </div>
                <div class="w-44 shrink-0">
                    <label for="payment_status" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Payment</label>
                    <x-ui.select name="payment_status" :options="[
                        '' => 'All Payment',
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                    ]" :value="request('payment_status')" class="h-11 rounded-xl py-0" />
                </div>
                <div class="shrink-0">
                    <x-ui.button type="submit" variant="primary" size="md" class="h-11 rounded-xl px-6">Filter</x-ui.button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-left">Order</th>
                            <th class="px-4 py-3 font-semibold text-center whitespace-nowrap">Status</th>
                            <th class="px-4 py-3 font-semibold text-center whitespace-nowrap">Payment</th>
                            <th class="px-4 py-3 font-semibold text-left">Date</th>
                            <th class="px-4 py-3 font-semibold text-left">Customer</th>
                            <th class="px-4 py-3 font-semibold text-left">Total</th>
                            <th class="px-4 py-3 font-semibold text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($orders as $order)
                            <tr
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition"
                                x-data="{
                                    orderCompleted: {{ $order->order_status === 'completed' ? 'true' : 'false' }},
                                    paymentPaid: {{ $order->payment_status === 'paid' ? 'true' : 'false' }},
                                    saving: false,
                                    async save() {
                                        this.saving = true;
                                        try {
                                            const res = await fetch(@js(route('admin.orders.update', $order->id)), {
                                                method: 'PUT',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-CSRF-TOKEN': csrf,
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                },
                                                body: JSON.stringify({
                                                    order_status: this.orderCompleted ? 'completed' : 'pending',
                                                    payment_status: this.paymentPaid ? 'paid' : 'unpaid',
                                                }),
                                            });
                                            const data = await res.json().catch(() => ({}));
                                            if (!res.ok) {
                                                throw new Error(data.errors?.order_status?.[0] || data.errors?.payment_status?.[0] || data.message || 'Update failed');
                                            }
                                            this.orderCompleted = data.order_status === 'completed';
                                            this.paymentPaid = data.payment_status === 'paid';
                                            if (typeof Toastify !== 'undefined') {
                                                Toastify({
                                                    text: data.message || 'Updated',
                                                    duration: 2000,
                                                    gravity: 'top',
                                                    position: 'right',
                                                    style: { background: 'linear-gradient(to right, #10b981, #059669)' },
                                                }).showToast();
                                            }
                                        } catch (e) {
                                            if (typeof Toastify !== 'undefined') {
                                                Toastify({
                                                    text: e.message || 'Could not update',
                                                    duration: 2500,
                                                    gravity: 'top',
                                                    position: 'right',
                                                    style: { background: 'linear-gradient(to right, #ef4444, #dc2626)' },
                                                }).showToast();
                                            }
                                            throw e;
                                        } finally {
                                            this.saving = false;
                                        }
                                    },
                                    async toggleComplete() {
                                        const prev = this.orderCompleted;
                                        this.orderCompleted = !prev;
                                        try {
                                            await this.save();
                                        } catch {
                                            this.orderCompleted = prev;
                                        }
                                    },
                                    async togglePaid() {
                                        const prev = this.paymentPaid;
                                        this.paymentPaid = !prev;
                                        try {
                                            await this.save();
                                        } catch {
                                            this.paymentPaid = prev;
                                        }
                                    },
                                }"
                            >
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">#{{ $order->id }}</td>
                                <td class="px-4 py-3 text-center">
                                    <button
                                        type="button"
                                        role="switch"
                                        :aria-checked="orderCompleted"
                                        @click="toggleComplete()"
                                        :disabled="saving"
                                        class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800 disabled:opacity-50 mx-auto"
                                        :class="orderCompleted ? 'bg-blue-600' : 'bg-gray-300 dark:bg-gray-600'"
                                    >
                                        <span
                                            class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow transition duration-200"
                                            :class="orderCompleted ? 'translate-x-5' : 'translate-x-0.5'"
                                        ></span>
                                    </button>
                                    <p class="text-[10px] text-gray-500 mt-1" x-text="orderCompleted ? 'Completed' : 'Pending'"></p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button
                                        type="button"
                                        role="switch"
                                        :aria-checked="paymentPaid"
                                        @click="togglePaid()"
                                        :disabled="saving"
                                        class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800 disabled:opacity-50 mx-auto"
                                        :class="paymentPaid ? 'bg-emerald-600' : 'bg-gray-300 dark:bg-gray-600'"
                                    >
                                        <span
                                            class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow transition duration-200"
                                            :class="paymentPaid ? 'translate-x-5' : 'translate-x-0.5'"
                                        ></span>
                                    </button>
                                    <p class="text-[10px] text-gray-500 mt-1" x-text="paymentPaid ? 'Paid' : 'Unpaid'"></p>
                                </td>
                                
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400 whitespace-nowrap text-xs">
                                    {{ $order->created_at?->format('M d, Y h:i A') }}
                                </td>
                                
                                
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400 min-w-[10rem]">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</div>
                                    <div class="text-xs">{{ $order->customer_phone }}</div>
                                </td>
                                
                                <td class="px-4 py-3 whitespace-nowrap">${{ number_format((float) $order->total_amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300" title="View">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" class="inline" onsubmit="return confirm('Soft delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-icon-button" title="Delete"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
