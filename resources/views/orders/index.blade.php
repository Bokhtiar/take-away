@extends('users.layouts.app', ['variant' => 'app'])

@section('title', 'My Orders | RestaurantPro')

@section('content')
    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-16">
        <div class="flex items-end justify-between gap-6 mb-10">
            <div>
                <span class="text-xs uppercase tracking-[0.5em] gold-text">Order History</span>
                <h1 class="text-4xl md:text-5xl font-serif mt-3">My Orders</h1>
                <p class="text-gray-400 mt-3 max-w-2xl">Track your recent orders and view item breakdown.</p>
            </div>
            <a href="/#menu" class="hidden md:inline-flex items-center px-5 py-3 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                Continue Ordering
            </a>
        </div>

        <div class="bg-[#121212] border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-black/40">
                        <tr class="text-gray-300 uppercase tracking-widest text-xs">
                            <th class="text-left px-6 py-4">Order</th>
                            <th class="text-left px-6 py-4">Status</th>
                            <th class="text-left px-6 py-4">Payment</th>
                            <th class="text-left px-6 py-4">Total</th>
                            <th class="text-left px-6 py-4">Date</th>
                            <th class="text-left px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($orders as $order)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 font-semibold text-white">#{{ $order->id }}</td>
                                <td class="px-6 py-4 capitalize text-gray-300">{{ $order->order_status }}</td>
                                <td class="px-6 py-4 capitalize text-gray-300">{{ $order->payment_status }}</td>
                                <td class="px-6 py-4 font-semibold gold-text">${{ number_format((float) $order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-gray-400">{{ $order->created_at?->format('d M Y h:i A') }}</td>
                                <td class="px-6 py-4">
                                    <a class="inline-flex items-center px-4 py-2 border border-gold/60 text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all"
                                       href="{{ route('orders.show', $order->id) }}">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-500">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($orders->hasPages())
            <div class="mt-10 flex justify-center">
                <div class="bg-black/30 border border-white/10 rounded-2xl px-4 py-3">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </main>
@endsection
