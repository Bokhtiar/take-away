<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Oasis d'Or | Fine Dining & Luxury Cuisine</title>
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
</head>
<body class="overflow-x-hidden">

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
            @else
                <a href="{{ route('admin.login') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-gold text-white text-xs uppercase tracking-widest hover:bg-gold hover:text-black transition-all">
                    Login
                </a>
            @endauth
            <button class="md:hidden text-2xl" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>
    </nav>

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

        <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up">
            <button class="px-6 py-2 border-b-2 border-gold gold-text text-sm uppercase tracking-widest">All Items</button>
            <button class="px-6 py-2 border-b-2 border-transparent hover:border-gold transition-all text-sm uppercase tracking-widest text-gray-500 hover:text-white">Starters</button>
            <button class="px-6 py-2 border-b-2 border-transparent hover:border-gold transition-all text-sm uppercase tracking-widest text-gray-500 hover:text-white">Main Course</button>
            <button class="px-6 py-2 border-b-2 border-transparent hover:border-gold transition-all text-sm uppercase tracking-widest text-gray-500 hover:text-white">Desserts</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products as $product)
                @php
                    $productImage = $product->image_url ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800';
                @endphp
                <div class="food-card rounded-xl overflow-hidden" data-aos="fade-up">
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
                        <p class="text-gray-400 text-sm mb-6">{{ \Illuminate\Support\Str::limit($product->description ?: 'A delightful dish curated by our chef.', 120) }}</p>
                        <div class="grid grid-cols-2 gap-2">
                            <button onclick="openProductModal({{ $product->id }})" class="py-3 bg-white/5 border border-white/10 hover:border-gold transition-all text-xs font-bold uppercase tracking-widest">
                                Details
                            </button>
                            <button onclick="addToCart('{{ addslashes($product->name) }}', {{ (float) $product->price }})" class="py-3 bg-white/5 border border-white/10 hover:bg-gold hover:text-black transition-all flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest">
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
    </section>

    <section id="chef" class="py-24 bg-[#050505]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2" data-aos="fade-right">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 border-t-2 border-l-2 border-gold"></div>
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977730f90?auto=format&fit=crop&q=80&w=800" class="w-full grayscale hover:grayscale-0 transition-all duration-700 shadow-2xl">
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 border-b-2 border-r-2 border-gold"></div>
                    </div>
                </div>
                <div class="lg:w-1/2" data-aos="fade-left">
                    <span class="gold-text uppercase tracking-widest text-sm mb-4 block">Maestro of the Kitchen</span>
                    <h2 class="text-4xl md:text-5xl font-serif mb-6 leading-tight">Meet Executive Chef <br>Julian Vane</h2>
                    <p class="text-gray-400 mb-8 leading-relaxed">With over three decades of experience in Michelin-starred kitchens across Paris and Tokyo, Chef Vane brings a unique fusion of classical technique and avant-garde presentation to every plate.</p>
                    <div class="grid grid-cols-2 gap-8 mb-8">
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

    <footer class="py-12 border-t border-white/5 px-6 md:px-12 text-center">
        <div class="mb-8">
            <span class="text-3xl font-serif gold-text tracking-widest uppercase">L'Oasis d'Or</span>
        </div>
        <p class="text-[10px] text-gray-600 uppercase tracking-[0.2em]">&copy; 2024 L'Oasis d'Or Collective. All Culinary Rights Reserved.</p>
    </footer>

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

    <script>
        AOS.init({ duration: 1000, once: true, offset: 100 });
        const products = @json($products);

        let cart = [];
        const cartDrawer = document.getElementById('cart-drawer');
        const cartItemsContainer = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartTotal = document.getElementById('cart-total');
        const emptyMsg = document.getElementById('empty-cart-msg');
        const CART_STORAGE_KEY = 'luxury_restaurant_cart';

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

        function addToCart(name, price, addons = []) {
            const safeAddons = Array.isArray(addons) ? addons : [];

            if (safeAddons.length) {
                const addonTotal = safeAddons.reduce((sum, addon) => sum + Number(addon.price || 0), 0);
                upsertCartItem({ name, price: Number(price), qty: 1, addons: [], isAddonOnly: false });
                upsertCartItem({ name, price: addonTotal, qty: 1, addons: safeAddons, isAddonOnly: true });
            } else {
                upsertCartItem({ name, price: Number(price), qty: 1, addons: [], isAddonOnly: false });
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

        function checkout() {
            if (cart.length === 0) {
                showToast('Cart is empty');
                return;
            }
            showToast('Redirecting to secured payment...');
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
    </script>
</body>
</html>