@php $v = $variant ?? 'app'; @endphp

@if ($v === 'landing')
    <nav class="fixed w-full z-50 glass-nav py-4 px-6 md:px-12 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-2xl md:text-3xl font-serif gold-text font-bold tracking-widest uppercase">L'Oasis d'Or</span>
        </div>
        <div class="hidden md:flex gap-8 text-sm uppercase tracking-widest font-medium">
            <a href="#home" class="hover:text-[var(--gold)] transition-colors">Home</a>
            <a href="#menu" class="hover:text-[var(--gold)] transition-colors">Menu</a>
            <a href="#chef" class="hover:text-[var(--gold)] transition-colors">The Kitchen</a>
            <a href="#b2b" class="hover:text-[var(--gold)] transition-colors">Business</a>
            <a href="#contact" class="hover:text-[var(--gold)] transition-colors">Contact</a>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <div class="hidden md:flex items-center gap-3 border border-gold/40 bg-black/30 px-3 py-1.5 rounded-full">
                    @php
                        $avatarName = auth()->user()->name ?? 'User';
                        $avatarUrl = data_get(auth()->user(), 'image_url') ?: ('https://ui-avatars.com/api/?name=' . urlencode($avatarName) . '&background=D4AF37&color=0A0A0A');
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="avatar" class="w-9 h-9 rounded-full object-cover border border-gold/60">
                    <span class="text-sm text-white font-medium">{{ $avatarName }}</span>
                </div>
                <a href="{{ route('orders.index') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                    My Orders
                </a>
                <form method="POST" action="{{ route('user.logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('user.login') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                    Login
                </a>
                <a href="{{ route('user.register') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                    Register
                </a>
            @endauth
            <button class="md:hidden text-2xl" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>
    </nav>
@else
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
@endif
