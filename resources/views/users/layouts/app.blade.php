<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Take-Away | Fine Dining & Luxury Cuisine')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
        .text-soft-red { color: var(--soft-red); }

        .glass-nav {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }

        .hero-gradient {
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(10,10,10,1));
        }

        .food-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #151515;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .food-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
        }

        .cart-drawer {
            transform: translateX(100%);
            transition: transform 0.4s ease-in-out;
        }

        .cart-drawer.open {
            transform: translateX(0);
        }

        .btn-luxury {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-luxury::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255,255,255,0.1);
            transition: all 0.5s ease;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
        }

        .btn-luxury:hover::after {
            transform: translate(-50%, -50%) scale(1);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body class="overflow-x-hidden">
    @include('users.layouts.partial.header', ['variant' => $variant ?? 'app'])

    @yield('content')

    @include('users.layouts.partial.footer', ['variant' => $variant ?? 'app'])

    @stack('scripts')
</body>
</html>
