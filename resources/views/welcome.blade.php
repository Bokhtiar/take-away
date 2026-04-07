@extends('users.layouts.app', ['variant' => 'landing'])

@section('title', 'Take-Away | Fine Dining & Luxury Cuisine')

@section('content')
    <button onclick="toggleCart()"
        class="fixed right-4 md:right-6 top-1/2 -translate-y-1/2 z-[90] w-14 h-14 rounded-full border border-gold/70 bg-black/80 backdrop-blur-md flex items-center justify-center hover:bg-gold hover:text-black transition-all group">
        <i class="fa-solid fa-utensils text-xl gold-text group-hover:text-black"></i>
        <span id="cart-count"
            class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-black">0</span>
    </button>

    <section id="home" class="relative h-screen w-full flex items-center justify-center overflow-hidden">
        <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=80&w=2000" alt="Hero" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="relative text-center px-4" data-aos="fade-up" data-aos-duration="1500">
            <span class="gold-text uppercase tracking-[0.5em] text-sm mb-4 block">Experience Excellence</span>
            <h1 class="text-5xl md:text-8xl font-serif mb-8 leading-tight">Savor the Art of <br><span class="italic">Fine Dining</span></h1>
            <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                <a href="#menu" class="btn-luxury px-10 py-4 bg-gold text-black font-bold uppercase tracking-widest text-sm hover:bg-white transition-all">Explore Menu</a>
                <a href="#contact" class="btn-luxury px-10 py-4 border border-gold text-white font-bold uppercase tracking-widest text-sm hover:bg-gold hover:text-black transition-all">Book a Table</a>
            </div>
        </div>
    </section>

    <section id="menu" class="py-24 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-serif mb-4">The Culinary Collection</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Handcrafted by our master chefs using the finest seasonal ingredients sourced globally.</p>
        </div>

        <div id="category-tabs" class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up">
            <button type="button" data-category="all"
                class="category-tab px-6 py-2 border-b-2 border-gold gold-text text-sm uppercase tracking-widest">
                All Items
            </button>
        </div>

        <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products as $product)
                @php
                    $productImage = $product->image_url ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800';
                @endphp
                <div class="food-card rounded-xl overflow-hidden product-card"
                    data-aos="fade-up"
                    data-category="{{ strtolower($product->category?->name ?? 'uncategorized') }}">
                    <div class="h-64 overflow-hidden relative group">
                        <img src="{{ $productImage }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $product->name }}">
                        @if($product->category)
                            <div class="absolute top-4 right-4 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full text-xs gold-text border border-gold/30">
                                {{ $product->category->name }}
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2 gap-3">
                            <h3 class="text-xl font-serif">{{ $product->name }}</h3>
                            <span class="gold-text font-bold">${{ number_format((float) $product->price, 2) }}</span>
                        </div>
                        <p class="text-gray-400 text-sm mb-4">{{ \Illuminate\Support\Str::limit($product->description ?: 'A delightful dish curated by our chef.', 120) }}</p>
                        @if ($product->productAddons->isNotEmpty())
                            @php $addonCount = $product->productAddons->count(); @endphp
                            <button type="button"
                                onclick="openProductModal({{ $product->id }})"
                                class="mb-4 w-full inline-flex items-center justify-center gap-2 rounded-lg border border-gold/30 bg-gold/5 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-gold transition hover:bg-gold/15 hover:border-gold/50 focus:outline-none focus:ring-2 focus:ring-gold/40">
                                <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                                <span>{{ $addonCount }} add-on{{ $addonCount === 1 ? '' : 's' }}</span>
                            </button>
                        @endif
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" onclick="openProductModal({{ $product->id }})" class="py-3 bg-white/5 border border-white/10 hover:border-gold transition-all text-xs font-bold uppercase tracking-widest">
                                Details
                            </button>
                            <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ (float) $product->price }})" class="py-3 bg-white/5 border border-white/10 hover:bg-gold hover:text-black transition-all flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest">
                                <i class="fa-solid fa-cart-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-16">
                    No products available right now.
                </div>
            @endforelse
        </div>

        @if ($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->hasPages())
            <div class="mt-12 flex justify-center">
                <div class="bg-black/30 border border-white/10 rounded-2xl px-4 py-3">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </section>

    <section id="chef" class="py-24 bg-[#050505]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            @php
                $headName = $headChef?->name ?? 'Julian Vane';
                $headDesignation = $headChef?->designation ?? 'Executive Chef';
                $headImage = $headChef?->image_url ?: 'https://images.unsplash.com/photo-1583394838336-acd977730f90?auto=format&fit=crop&q=80&w=800';
                $team = $juniorChefs ?? collect();
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6" data-aos="fade-right">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 border-t-2 border-l-2 border-gold"></div>
                        <img src="{{ $headImage }}" alt="{{ $headName }}" class="w-full grayscale hover:grayscale-0 transition-all duration-700 shadow-2xl">
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 border-b-2 border-r-2 border-gold"></div>

                        <div class="absolute bottom-4 left-4 right-4 bg-black/70 backdrop-blur-md border border-white/10 rounded-2xl px-5 py-4">
                            <p class="text-xs uppercase tracking-[0.35em] text-gray-300">Head Chef</p>
                            <p class="font-serif text-2xl gold-text mt-1">{{ $headName }}</p>
                            <p class="text-sm text-gray-300 mt-1">{{ $headDesignation }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6" data-aos="fade-left">
                    <span class="gold-text uppercase tracking-widest text-sm mb-4 block">The Culinary Team</span>
                    <h2 class="text-4xl md:text-5xl font-serif mb-6 leading-tight">
                        Meet Our <span class="italic">Chefs</span>
                    </h2>
                    <p class="text-gray-400 mb-8 leading-relaxed">
                        From signature mains to delicate pastries — our kitchen team crafts each plate with precision and care.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($team as $c)
                            @php
                                $cImg = $c->image_url ?: ('https://ui-avatars.com/api/?name=' . urlencode($c->name) . '&background=0A0A0A&color=D4AF37');
                            @endphp
                            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-black/30 hover:border-gold/60 transition">
                                <div class="absolute -top-3 -left-3 w-14 h-14 border-t-2 border-l-2 border-gold/80"></div>
                                <div class="absolute -bottom-3 -right-3 w-14 h-14 border-b-2 border-r-2 border-gold/80"></div>

                                <div class="flex items-center gap-4 p-5">
                                    <img src="{{ $cImg }}" alt="{{ $c->name }}" class="w-32 h-32 rounded-2xl object-cover border border-gold/40">
                                    <div class="min-w-0">
                                        <p class="text-white font-semibold truncate text-base">{{ $c->name }}</p>
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-400 truncate mt-1">{{ $c->designation }}</p>
                                    </div>
                                </div>

                                {{-- <div class="px-5 pb-5">
                                    <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-xl px-4 py-2.5">
                                        <p class="text-[11px] uppercase tracking-[0.35em] text-gray-200">Junior Chef</p>
                                    </div>
                                </div> --}}
                            </div>
                        @empty
                            <div class="p-5 rounded-2xl border border-white/10 bg-black/30 text-gray-400">
                                No junior chefs added yet.
                            </div>
                        @endforelse
                    </div>

                    <div class="grid grid-cols-2 gap-8 mt-10">
                        <div>
                            <h4 class="gold-text font-serif text-2xl">15+</h4>
                            <p class="text-gray-500 text-sm uppercase tracking-wider">Culinary Awards</p>
                        </div>
                        <div>
                            <h4 class="gold-text font-serif text-2xl">30+</h4>
                            <p class="text-gray-500 text-sm uppercase tracking-wider">Years Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="b2b" class="py-24 px-6 md:px-12 bg-[#080808]">
        <div class="max-w-4xl mx-auto border border-gold/20 p-8 md:p-16 rounded-3xl" data-aos="zoom-in">
            <div class="text-center mb-12">
                <span class="gold-text uppercase tracking-widest text-sm mb-4 block">Corporate & Events</span>
                <h2 class="text-4xl font-serif mb-4">B2B Bespoke Catering</h2>
                <p class="text-gray-500">Tailored culinary experiences for your corporate events and high-end galas.</p>
            </div>
            <form id="b2bForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col">
                    <label class="text-xs uppercase tracking-widest text-gray-500 mb-2">Company Name</label>
                    <input type="text" class="bg-white/5 border border-white/10 p-4 focus:border-gold outline-none transition-all" placeholder="Enter Company">
                </div>
                <div class="flex flex-col">
                    <label class="text-xs uppercase tracking-widest text-gray-500 mb-2">Quantity of Guests</label>
                    <input type="number" class="bg-white/5 border border-white/10 p-4 focus:border-gold outline-none transition-all" placeholder="50+">
                </div>
                <div class="flex flex-col md:col-span-2">
                    <label class="text-xs uppercase tracking-widest text-gray-500 mb-2">Select Primary Cuisine Theme</label>
                    <select class="bg-white/5 border border-white/10 p-4 focus:border-gold outline-none transition-all text-gray-400">
                        <option>Classical French Heritage</option>
                        <option>Modern Asian Fusion</option>
                        <option>Mediterranean Gold</option>
                        <option>Chef Julian's Selection</option>
                    </select>
                </div>
                <button type="submit" class="md:col-span-2 py-4 bg-gold text-black font-bold uppercase tracking-widest hover:bg-white transition-all">Submit Quotation Request</button>
            </form>
        </div>
    </section>

    <div id="cart-drawer" class="fixed top-0 right-0 w-full md:w-[400px] h-full bg-[#0d0d0d] z-[100] cart-drawer shadow-[-20px_0_50px_rgba(0,0,0,0.8)] flex flex-col">
        <div class="p-8 border-b border-white/5 flex justify-between items-center">
            <h3 class="font-serif text-2xl gold-text">Your Selection</h3>
            <button onclick="toggleCart()" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark text-2xl"></i></button>
        </div>
        <div id="cart-items" class="flex-grow overflow-y-auto p-8 space-y-6">
            <div id="empty-cart-msg" class="text-center py-20 text-gray-600">
                <i class="fa-solid fa-utensils text-4xl mb-4 block"></i>
                <p>Your culinary journey starts here.</p>
            </div>
        </div>
        <div class="p-8 border-t border-white/5 bg-black">
            <div class="flex justify-between mb-4">
                <span class="text-gray-400 uppercase tracking-widest text-sm">Subtotal</span>
                <span id="cart-total" class="gold-text font-bold">$0.00</span>
            </div>
            <button onclick="checkout()" class="w-full py-4 bg-gold text-black font-bold uppercase tracking-widest hover:bg-white transition-all">Proceed to Checkout</button>
        </div>
    </div>

    <div id="toast" class="fixed bottom-10 left-10 z-[1000] bg-gold text-black px-6 py-3 font-bold uppercase tracking-widest text-xs opacity-0 pointer-events-none transition-all transform translate-y-10">
        Item added to selection
    </div>

    <div id="product-modal" class="fixed inset-0 z-[110] hidden">
        <div class="absolute inset-0 bg-black/70" onclick="closeProductModal()"></div>
        <div class="absolute inset-x-0 top-8 mx-auto w-[95%] md:w-[760px] max-h-[88vh] overflow-y-auto bg-[#111] border border-gold/40 rounded-2xl p-6 md:p-8">
            <div class="flex justify-between items-start gap-4 mb-5">
                <div>
                    <h3 id="modal-product-name" class="text-3xl font-serif gold-text"></h3>
                    <p id="modal-product-price" class="text-sm text-gray-300 mt-1"></p>
                </div>
                <button onclick="closeProductModal()" class="text-gray-400 hover:text-white text-2xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <p id="modal-product-description" class="text-gray-300 mb-6"></p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-white/10 rounded-xl p-4 bg-black/20">
                    <h4 class="font-semibold uppercase tracking-widest text-xs text-gold mb-3">Ingredients</h4>
                    <ul id="modal-ingredients" class="space-y-2 text-sm text-gray-300"></ul>
                </div>
                <div class="border border-white/10 rounded-xl p-4 bg-black/20">
                    <h4 class="font-semibold uppercase tracking-widest text-xs text-gold mb-3">Addons</h4>
                    <ul id="modal-addons" class="space-y-2 text-sm text-gray-300"></ul>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        AOS.init({ duration: 1000, once: true, offset: 100 });
        const products = @json(method_exists($products, 'items') ? $products->items() : $products);

        let cart = [];
        const cartDrawer = document.getElementById('cart-drawer');
        const cartItemsContainer = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartTotal = document.getElementById('cart-total');
        const emptyMsg = document.getElementById('empty-cart-msg');
        const CART_STORAGE_KEY = 'luxury_restaurant_cart';
        const isLoggedIn = @json(auth()->check());

        function normalizeCategoryName(name) {
            return String(name || 'uncategorized').trim().toLowerCase();
        }

        function renderCategoryTabs() {
            const el = document.getElementById('category-tabs');
            if (!el) return;

            const categories = new Map();
            (products || []).forEach((p) => {
                const label = p?.category?.name || 'Uncategorized';
                const key = normalizeCategoryName(label);
                categories.set(key, label);
            });

            // Keep the first "All Items" button and clear the rest
            const allBtn = el.querySelector('[data-category="all"]');
            el.innerHTML = '';
            if (allBtn) el.appendChild(allBtn);

            Array.from(categories.entries())
                .sort((a, b) => String(a[1]).localeCompare(String(b[1])))
                .forEach(([key, label]) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.dataset.category = key;
                    btn.className = 'category-tab px-6 py-2 border-b-2 border-transparent hover:border-gold transition-all text-sm uppercase tracking-widest text-gray-500 hover:text-white';
                    btn.textContent = label;
                    el.appendChild(btn);
                });

            el.addEventListener('click', (e) => {
                const btn = e.target.closest('.category-tab');
                if (!btn) return;
                setActiveCategory(btn.dataset.category || 'all');
            });
        }

        function setActiveCategory(categoryKey) {
            const key = categoryKey || 'all';
            const tabs = document.querySelectorAll('.category-tab');
            tabs.forEach((tab) => {
                const isActive = (tab.dataset.category || 'all') === key;
                tab.classList.toggle('border-gold', isActive);
                tab.classList.toggle('gold-text', isActive);
                tab.classList.toggle('text-gray-500', !isActive);
            });
            filterProductsByCategory(key);
        }

        function filterProductsByCategory(categoryKey) {
            const key = categoryKey || 'all';
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card) => {
                const cat = normalizeCategoryName(card.dataset.category);
                const show = key === 'all' ? true : (cat === key);
                card.classList.toggle('hidden', !show);
            });
        }

        function toggleCart() { cartDrawer.classList.toggle('open'); }

        function saveCartToStorage() {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
        }

        function loadCartFromStorage() {
            try {
                const raw = localStorage.getItem(CART_STORAGE_KEY);
                const parsed = raw ? JSON.parse(raw) : [];
                cart = Array.isArray(parsed) ? parsed : [];
                migrateLegacyCartItems();
            } catch (e) {
                cart = [];
            }
        }

        function getItemSignature(item) {
            const addonNames = (item.addons || []).map((a) => a.name).sort().join('|');
            return `${item.name}::${item.isAddonOnly ? 'addon' : 'base'}::${addonNames}`;
        }

        function upsertCartItem(newItem) {
            const signature = getItemSignature(newItem);
            const existing = cart.find((item) => getItemSignature(item) === signature);
            if (existing) {
                existing.qty += newItem.qty;
            } else {
                cart.push(newItem);
            }
        }

        function migrateLegacyCartItems() {
            if (!cart.length) return;
            const migrated = [];

            cart.forEach((item) => {
                const qty = Number(item.qty || 1);
                const basePrice = Number(item.price || 0);
                const addons = Array.isArray(item.addons) ? item.addons : [];

                if (addons.length && !item.isAddonOnly) {
                    const addonTotal = addons.reduce((sum, addon) => sum + Number(addon.price || 0), 0);
                    upsertIntoList(migrated, { name: item.name, price: basePrice, qty, addons: [], isAddonOnly: false });
                    upsertIntoList(migrated, { name: item.name, price: addonTotal, qty, addons, isAddonOnly: true });
                } else {
                    upsertIntoList(migrated, {
                        name: item.name,
                        price: basePrice,
                        qty,
                        addons,
                        isAddonOnly: !!item.isAddonOnly,
                    });
                }
            });

            cart = migrated;
        }

        function upsertIntoList(list, newItem) {
            const addonNames = (newItem.addons || []).map((a) => a.name).sort().join('|');
            const signature = `${newItem.name}::${newItem.isAddonOnly ? 'addon' : 'base'}::${addonNames}`;
            const existing = list.find((item) => {
                const itemAddons = (item.addons || []).map((a) => a.name).sort().join('|');
                const itemSignature = `${item.name}::${item.isAddonOnly ? 'addon' : 'base'}::${itemAddons}`;
                return itemSignature === signature;
            });

            if (existing) existing.qty += newItem.qty;
            else list.push(newItem);
        }

        function addToCart(productId, name, price, addons = []) {
            const safeAddons = Array.isArray(addons) ? addons : [];

            if (safeAddons.length) {
                const addonTotal = safeAddons.reduce((sum, addon) => sum + Number(addon.price || 0), 0);
                upsertCartItem({ product_id: Number(productId), name, price: Number(price), qty: 1, addons: [], isAddonOnly: false });
                upsertCartItem({ product_id: Number(productId), name, price: addonTotal, qty: 1, addons: safeAddons, isAddonOnly: true });
            } else {
                upsertCartItem({ product_id: Number(productId), name, price: Number(price), qty: 1, addons: [], isAddonOnly: false });
            }

            updateCartUI();
            showToast(name + ' added');
        }

        function removeFromCart(cartIndex) {
            cart.splice(cartIndex, 1);
            updateCartUI();
        }

        function updateCartUI() {
            cartItemsContainer.innerHTML = '';
            let total = 0;
            let count = 0;

            if (cart.length === 0) {
                cartItemsContainer.appendChild(emptyMsg);
            } else {
                cart.forEach((item, index) => {
                    const unitTotal = Number(item.price);
                    total += unitTotal * item.qty;
                    count += item.qty;
                    const addonNames = (item.addons || []).map((a) => a.name);
                    const titleWithAddons = item.isAddonOnly && addonNames.length
                        ? `${item.name} (${addonNames.join(', ')})`
                        : item.name;
                    const baseLine = item.isAddonOnly
                        ? `<p class="text-[11px] text-gray-400 mt-1">Addon Pack: $${Number(item.price).toFixed(2)}</p>`
                        : `<p class="text-[11px] text-gray-400 mt-1">Base: $${Number(item.price).toFixed(2)}</p>`;
                    const addonLine = item.isAddonOnly && addonNames.length
                        ? `<p class="text-[11px] text-gray-500">Addons: ${item.addons.map((a) => `${a.name} ($${Number(a.price).toFixed(2)})`).join(', ')}</p>`
                        : `<p class="text-[11px] text-gray-500">Addons: None</p>`;
                    const div = document.createElement('div');
                    div.className = 'flex justify-between items-center';
                    div.innerHTML = `
                        <div>
                            <h4 class="text-sm font-bold text-white uppercase tracking-wider">${titleWithAddons}</h4>
                            <p class="text-xs gold-text">${item.qty} x $${unitTotal.toFixed(2)}</p>
                            ${baseLine}
                            ${addonLine}
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-soft-red hover:text-white transition-all">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    `;
                    cartItemsContainer.appendChild(div);
                });
            }

            cartCount.textContent = count;
            cartTotal.textContent = '$' + total.toFixed(2);
            saveCartToStorage();
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
            }, 2000);
        }

        async function checkout() {
            if (cart.length === 0) {
                showToast('Cart is empty');
                return;
            }

            if (!isLoggedIn) {
                window.location.href = '{{ route('user.login') }}';
                return;
            }

            const payloadItems = cart
                .filter((item) => Number(item.product_id) > 0)
                .map((item) => ({
                    product_id: Number(item.product_id),
                    qty: Number(item.qty || 1),
                    base_price: item.isAddonOnly ? 0 : Number(item.price || 0),
                    addons: (item.addons || []).map((addon) => ({
                        addon_id: Number(addon.id),
                    })).filter((addon) => addon.addon_id > 0),
                }));

            if (!payloadItems.length) {
                showToast('No valid product found in cart');
                return;
            }

            const defaultName = @json(auth()->user()->name ?? '');
            const defaultPhone = @json(data_get(auth()->user(), 'phone', ''));
            const customerName = defaultName || window.prompt('Enter customer name');
            const customerPhone = defaultPhone || window.prompt('Enter customer phone');

            if (!customerName || !customerPhone) {
                showToast('Name and phone are required');
                return;
            }

            try {
                const response = await fetch('{{ route('orders.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        customer_name: customerName,
                        customer_phone: customerPhone,
                        items: payloadItems,
                    }),
                });

                if (!response.ok) {
                    throw new Error('Order request failed');
                }

                const result = await response.json();
                cart = [];
                updateCartUI();
                showToast(`Order #${result.order_id} placed successfully`);
            } catch (error) {
                showToast('Failed to place order');
            }
        }

        document.getElementById('b2bForm').addEventListener('submit', (e) => {
            e.preventDefault();
            showToast('Quotation request sent to concierge.');
            e.target.reset();
        });

        function toggleMobileMenu() {
            showToast('Luxury menu opening...');
        }

        function openProductModal(productId) {
            const product = products.find((p) => p.id === productId);
            if (!product) return;

            document.getElementById('modal-product-name').textContent = product.name;
            document.getElementById('modal-product-price').textContent = '$' + Number(product.price).toFixed(2);
            document.getElementById('modal-product-description').textContent = product.description || 'No description available.';

            const ingredientsEl = document.getElementById('modal-ingredients');
            ingredientsEl.innerHTML = '';
            if (product.product_ingredients && product.product_ingredients.length) {
                product.product_ingredients.forEach((item) => {
                    const li = document.createElement('li');
                    const ingredientName = item.ingredient ? item.ingredient.name : 'Ingredient';
                    const unit = item.ingredient && item.ingredient.unit ? item.ingredient.unit : '';
                    li.textContent = ingredientName + ' - ' + item.qty + (unit ? ' ' + unit : '');
                    ingredientsEl.appendChild(li);
                });
            } else {
                ingredientsEl.innerHTML = '<li class="text-gray-500">No ingredients configured.</li>';
            }

            const addonsEl = document.getElementById('modal-addons');
            addonsEl.innerHTML = '';
            if (product.product_addons && product.product_addons.length) {
                product.product_addons.forEach((item, idx) => {
                    const li = document.createElement('li');
                    const addonName = item.addon ? item.addon.name : 'Addon';
                    const addonPrice = item.addon ? Number(item.addon.price).toFixed(2) : '0.00';
                    const addonId = item.addon ? item.addon.id : ('addon-' + idx);
                    li.innerHTML = `
                        <div class="flex items-center justify-between gap-3 border border-white/10 rounded-lg px-3 py-2">
                            <span>${addonName}</span>
                            <div class="flex items-center gap-3">
                                <span class="text-gold">$${addonPrice}</span>
                                <button type="button"
                                    class="text-gold hover:text-white transition-all"
                                    onclick="addProductWithAddon(${product.id}, '${addonId}', '${addonName.replace(/'/g, "\\'")}', ${addonPrice})">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    addonsEl.appendChild(li);
                });
            } else {
                addonsEl.innerHTML = '<li class="text-gray-500">No addons configured.</li>';
            }

            document.getElementById('product-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function addProductWithAddon(productId, addonId, addonName, addonPrice) {
            const product = products.find((p) => p.id === productId);
            if (!product) return;

            upsertCartItem({
                product_id: Number(product.id),
                name: product.name,
                price: Number(addonPrice),
                qty: 1,
                addons: [{
                    id: addonId,
                    name: addonName,
                    price: Number(addonPrice),
                }],
                isAddonOnly: true,
            });
            updateCartUI();
            showToast(product.name + ' addon added');
        }

        function closeProductModal() {
            document.getElementById('product-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        loadCartFromStorage();
        updateCartUI();
        renderCategoryTabs();
        setActiveCategory('all');
    </script>
@endpush