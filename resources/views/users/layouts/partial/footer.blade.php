@php $v = $variant ?? 'app'; @endphp

@if ($v === 'landing')
    <footer class="py-14 border-t border-white/5 px-6 md:px-12 bg-[#050505]">
        <div class="max-w-7xl mx-auto text-center">
            <div class="mb-6">
                <span class="text-3xl font-serif gold-text tracking-widest uppercase">L'Oasis d'Or</span>
            </div>
            <p class="text-gray-500 text-sm max-w-2xl mx-auto leading-relaxed">
                Fine dining &amp; take-away — crafted for moments worth savouring.
            </p>
            <p class="text-[10px] text-gray-600 uppercase tracking-[0.2em] mt-8">
                &copy; {{ date('Y') }} L'Oasis d'Or Collective. All Culinary Rights Reserved.
            </p>
        </div>
    </footer>
@else
    <footer class="py-14 border-t border-white/5 px-6 md:px-12 bg-[#050505]">
        <div class="max-w-7xl mx-auto text-center">
            <div class="mb-6">
                <a href="{{ url('/') }}" class="inline-block text-3xl font-serif gold-text tracking-widest uppercase hover:opacity-90 transition-opacity">L'Oasis d'Or</a>
            </div>
            <p class="text-gray-500 text-sm max-w-2xl mx-auto leading-relaxed">
                Crafted experiences, curated flavors — thank you for dining with us.
            </p>
            <p class="text-gray-600 text-xs mt-6 uppercase tracking-widest">© {{ date('Y') }} RestaurantPro</p>
        </div>
    </footer>
@endif
