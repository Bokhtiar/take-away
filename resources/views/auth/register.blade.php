<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register | RestaurantPro</title>
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

        .glass {
            background: rgba(10, 10, 10, 0.72);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(212, 175, 55, 0.22);
            box-shadow: 0 30px 80px rgba(0,0,0,0.55);
        }

        .hero-gradient {
            background: radial-gradient(1200px 600px at 12% 16%, rgba(212,175,55,0.18), rgba(0,0,0,0) 60%),
                        radial-gradient(900px 500px at 88% 34%, rgba(165,42,42,0.10), rgba(0,0,0,0) 55%),
                        linear-gradient(to bottom, rgba(0,0,0,0.35), rgba(10,10,10,0.98));
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden">
    <div class="relative min-h-screen flex items-center justify-center px-5 py-14">
        <img
            src="https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?auto=format&fit=crop&q=80&w=2200"
            alt="Restaurant background"
            class="absolute inset-0 w-full h-full object-cover"
        >
        <div class="absolute inset-0 hero-gradient"></div>

        <div class="relative w-full max-w-md glass rounded-3xl p-8 md:p-10">
            <div class="mb-8">
                <a href="/" class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.35em] text-gray-300 hover:text-white transition">
                    <span class="gold-text">←</span> Back to Home
                </a>
                <div class="mt-5">
                    <span class="text-xs uppercase tracking-[0.5em] gold-text">Join us</span>
                    <h1 class="text-3xl md:text-4xl font-serif mt-2 leading-tight">
                        Create your <span class="italic gold-text">Account</span>
                    </h1>
                    <p class="text-sm text-gray-300 mt-3 leading-relaxed">
                        Register with your phone number. Email is optional.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('user.register.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="text-xs uppercase tracking-[0.25em] text-gray-300">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Your name"
                        class="mt-2 w-full h-12 px-4 rounded-xl bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-gold transition"
                    >
                    @error('name')
                        <p class="text-[12px] text-red-300 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs uppercase tracking-[0.25em] text-gray-300">Phone Number</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        placeholder="01XXXXXXXXX"
                        class="mt-2 w-full h-12 px-4 rounded-xl bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-gold transition"
                    >
                    @error('phone')
                        <p class="text-[12px] text-red-300 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs uppercase tracking-[0.25em] text-gray-300">Email (Optional)</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        class="mt-2 w-full h-12 px-4 rounded-xl bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-gold transition"
                    >
                    @error('email')
                        <p class="text-[12px] text-red-300 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs uppercase tracking-[0.25em] text-gray-300">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="mt-2 w-full h-12 px-4 rounded-xl bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-gold transition"
                    >
                    @error('password')
                        <p class="text-[12px] text-red-300 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs uppercase tracking-[0.25em] text-gray-300">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="••••••••"
                        class="mt-2 w-full h-12 px-4 rounded-xl bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-gold transition"
                    >
                </div>

                <button type="submit" class="w-full h-12 rounded-xl bg-gold text-black font-bold uppercase tracking-[0.25em] hover:bg-white transition-all">
                    Register
                </button>
            </form>

            <div class="mt-7 pt-6 border-t border-white/10">
                <p class="text-sm text-gray-300">
                    Already have an account?
                    <a href="{{ route('user.login') }}" class="gold-text hover:text-white transition font-semibold">Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

