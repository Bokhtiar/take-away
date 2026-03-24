@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Orders" description="Manage customer orders from admin panel." />

        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by id, customer, phone"
                class="h-11 w-64 px-4 text-sm border border-gray-300 rounded-xl bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white">

            <x-ui.select name="order_status" :options="[
                '' => 'All Status',
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'preparing' => 'Preparing',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ]" :value="request('order_status')" />

            <x-ui.select name="payment_status" :options="[
                '' => 'All Payment',
                'unpaid' => 'Unpaid',
                'paid' => 'Paid',
                'refunded' => 'Refunded',
            ]" :value="request('payment_status')" />

            <x-ui.button type="submit" variant="secondary" size="md">Filter</x-ui.button>
        </form>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left">Order</th>
                            <th class="px-6 py-3 font-semibold text-left">Customer</th>
                            <th class="px-6 py-3 font-semibold text-left">Status</th>
                            <th class="px-6 py-3 font-semibold text-left">Payment</th>
                            <th class="px-6 py-3 font-semibold text-left">Total</th>
                            <th class="px-6 py-3 font-semibold text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    <div>{{ $order->customer_name }}</div>
                                    <div class="text-xs">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="px-6 py-4 capitalize">{{ $order->order_status }}</td>
                                <td class="px-6 py-4 capitalize">{{ $order->payment_status }}</td>
                                <td class="px-6 py-4">${{ number_format((float) $order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="show-icon-button" title="View"><i class="ri-eye-line"></i></a>
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
                                <td colspan="6" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">No orders found</td>
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

