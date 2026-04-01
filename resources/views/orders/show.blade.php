<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} | RestaurantPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');

        :root {
            --gold: #D4AF37;
            --soft-red: #A52A2A;
            --black: #0A0A0A;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--black);
            color: #f5f5f5;
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .gold-text { color: var(--gold); }
        .bg-gold { background-color: var(--gold); }
        .border-gold { border-color: var(--gold); }

        .glass-nav {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <nav class="fixed w-full z-50 glass-nav py-4 px-6 md:px-12 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <a href="/" class="text-2xl md:text-3xl font-serif gold-text font-bold tracking-widest uppercase">L'Oasis d'Or</a>
        </div>
        <div class="hidden md:flex gap-8 text-sm uppercase tracking-widest font-medium">
            <a href="/#home" class="hover:text-[var(--gold)] transition-colors">Home</a>
            <a href="/#menu" class="hover:text-[var(--gold)] transition-colors">Menu</a>
            <a href="/#contact" class="hover:text-[var(--gold)] transition-colors">Contact</a>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-3 border border-gold/40 bg-black/30 px-3 py-1.5 rounded-full">
                @php
                    $avatarName = auth()->user()->name ?? 'User';
                    $avatarUrl = data_get(auth()->user(), 'image_url') ?: ('https://ui-avatars.com/api/?name=' . urlencode($avatarName) . '&background=D4AF37&color=0A0A0A');
                @endphp
                <img src="{{ $avatarUrl }}" alt="avatar" class="w-9 h-9 rounded-full object-cover border border-gold/60">
                <span class="text-sm text-white font-medium">{{ $avatarName }}</span>
            </div>
            <form method="POST" action="{{ route('user.logout') }}" class="hidden md:block">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                    Logout
                </button>
            </form>
        </div>
    </nav>

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

    <footer class="py-12 border-t border-white/5 px-6 md:px-12 text-center">
        <div class="mb-6">
            <span class="text-3xl font-serif gold-text tracking-widest uppercase">L'Oasis d'Or</span>
        </div>
        <p class="text-gray-500 text-sm max-w-2xl mx-auto">
            Crafted experiences, curated flavors — thank you for dining with us.
        </p>
        <p class="text-gray-600 text-xs mt-6 uppercase tracking-widest">© {{ date('Y') }} RestaurantPro</p>
    </footer>
</body>
</html>

