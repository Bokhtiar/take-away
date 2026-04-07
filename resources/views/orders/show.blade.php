@extends('users.layouts.app', ['variant' => 'app'])

@section('title')
    Order #{{ $order->id }} | RestaurantPro
@endsection

@section('content')
    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-16 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <span class="text-xs uppercase tracking-[0.5em] gold-text">Order Details</span>
                <h1 class="text-4xl md:text-5xl font-serif mt-3">Order #{{ $order->id }}</h1>
                <p class="text-gray-400 mt-3">A full breakdown of items and addons.</p>
            </div>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-5 py-3 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                Back to Orders
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-[#121212] border border-white/10 rounded-2xl p-5">
                <p class="text-xs uppercase tracking-widest text-gray-500">Customer</p>
                <p class="font-semibold text-white mt-2">{{ $order->customer_name }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ $order->customer_phone }}</p>
            </div>
            <div class="bg-[#121212] border border-white/10 rounded-2xl p-5">
                <p class="text-xs uppercase tracking-widest text-gray-500">Order Status</p>
                <p class="font-semibold text-white mt-2 capitalize">{{ $order->order_status }}</p>
            </div>
            <div class="bg-[#121212] border border-white/10 rounded-2xl p-5">
                <p class="text-xs uppercase tracking-widest text-gray-500">Payment</p>
                <p class="font-semibold text-white mt-2 capitalize">{{ $order->payment_status }}</p>
            </div>
            <div class="bg-[#121212] border border-white/10 rounded-2xl p-5">
                <p class="text-xs uppercase tracking-widest text-gray-500">Total</p>
                <p class="font-semibold gold-text mt-2 text-xl">${{ number_format((float) $order->total_amount, 2) }}</p>
            </div>
        </div>

        <div class="bg-[#121212] border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
                <h2 class="font-serif text-2xl">Items</h2>
                <span class="text-xs uppercase tracking-widest text-gray-500">{{ $order->items->count() }} items</span>
            </div>

            <div class="divide-y divide-white/10">
                @foreach($order->items as $item)
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-serif text-white">{{ $item->product?->name ?? 'Product' }}</h3>
                                <p class="text-sm text-gray-400 mt-2">
                                    Qty: <span class="text-white font-semibold">{{ $item->quantity }}</span>
                                    <span class="mx-2 text-gray-600">•</span>
                                    Unit Price: <span class="gold-text font-semibold">${{ number_format((float) $item->price, 2) }}</span>
                                </p>
                                @if($item->addons->isNotEmpty())
                                    <p class="text-sm text-gray-400 mt-2">
                                        Addons:
                                        <span class="text-gray-300">
                                            {{ $item->addons->map(fn($addon) => ($addon->addon?->name ?? 'Addon') . ' ($' . number_format((float) $addon->price, 2) . ')')->implode(', ') }}
                                        </span>
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500 mt-2">Addons: None</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-widest text-gray-500">Line Total</p>
                                <p class="text-2xl font-semibold gold-text mt-1">
                                    ${{ number_format(((float) $item->price) * $item->quantity, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
