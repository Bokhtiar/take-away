@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Orders" description="All orders, newest first. Use View to open full details." />

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-nowrap items-end gap-3 w-full min-w-0 overflow-x-auto pb-0.5">
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
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">Order</th>
                            <th class="px-6 py-3 font-semibold text-left">Date</th>
                            <th class="px-6 py-3 font-semibold text-left">Customer</th>
                            <th class="px-6 py-3 font-semibold text-left">Status</th>
                            <th class="px-6 py-3 font-semibold text-left">Payment</th>
                            <th class="px-6 py-3 font-semibold text-left">Total</th>
                            <th class="px-6 py-3 font-semibold text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400 whitespace-nowrap text-sm">
                                    {{ $order->created_at?->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    <div>{{ $order->customer_name }}</div>
                                    <div class="text-xs">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="px-6 py-4 capitalize">{{ $order->order_status }}</td>
                                <td class="px-6 py-4 capitalize">{{ $order->payment_status }}</td>
                                <td class="px-6 py-4">${{ number_format((float) $order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50" title="View order">
                                            <i class="ri-eye-line"></i> View
                                        </a>
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" class="inline" onsubmit="return confirm('Soft delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-icon-button" title="Soft Delete"><i class="ri-delete-bin-line"></i></button>
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

