<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | RestaurantPro</title>
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

