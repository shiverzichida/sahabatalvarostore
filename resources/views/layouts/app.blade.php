<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sahabat Alvaro Store — Authorized Main Distributor')</title>
    <meta name="description" content="Distributor resmi produk farmasi berkualitas tinggi di Indonesia.">
    
    <!-- Favicon — use store logo instead of Laravel default -->
    <link rel="icon" type="image/png" href="{{ asset('images/Sahabat Steroid flat transparent.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .primary-blue { color: #0056b3; }
        .bg-primary-blue { background-color: #0056b3; }
        .primary-green { color: #28a745; }
        .bg-primary-green { background-color: #28a745; }

        /* ─── Cart Badge ──────────────────────────────────────────── */
        .sa-cart-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px; height: 42px;
            border-radius: 12px;
            background: #f0f7ff;
            border: 1px solid #dbeafe;
            cursor: pointer;
            transition: all .2s;
        }
        .sa-cart-btn:hover {
            background: #dbeafe;
            transform: scale(1.05);
        }
        .sa-cart-btn svg { width: 22px; height: 22px; color: #0056b3; }
        .sa-cart-badge {
            position: absolute;
            top: -6px; right: -6px;
            width: 20px; height: 20px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(239,68,68,.4);
            animation: sa-badge-pop .3s ease;
        }
        @keyframes sa-badge-pop {
            0% { transform: scale(0); }
            60% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }

        /* ─── Cart Feedback Toast ─────────────────────────────────── */
        #sa-cart-feedback {
            position: fixed;
            top: 80px; right: 20px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(5,150,105,.3);
            transform: translateX(120%);
            transition: transform .4s cubic-bezier(.34,1.56,.64,1);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        #sa-cart-feedback.sa-feedback-show {
            transform: translateX(0);
        }

        /* ─── Cart Overlay ────────────────────────────────────────── */
        #sa-cart-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
        }
        #sa-cart-overlay.sa-overlay-show {
            opacity: 1;
            pointer-events: auto;
        }

        /* ─── Cart Drawer ─────────────────────────────────────────── */
        #sa-cart-drawer {
            position: fixed;
            top: 0; right: 0;
            width: 420px;
            max-width: 90vw;
            height: 100vh;
            background: #fff;
            box-shadow: -8px 0 40px rgba(0,0,0,.12);
            z-index: 999;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform .35s cubic-bezier(.32,.72,0,1);
        }
        #sa-cart-drawer.sa-drawer-open {
            transform: translateX(0);
        }
        .sa-drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        .sa-drawer-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sa-drawer-close {
            width: 36px; height: 36px;
            border: none;
            background: #f3f4f6;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }
        .sa-drawer-close:hover { background: #e5e7eb; }
        .sa-drawer-close svg { width: 18px; height: 18px; color: #6b7280; }

        .sa-drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px 24px;
        }

        /* Empty state */
        #sa-cart-drawer-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            color: #9ca3af;
            text-align: center;
        }
        #sa-cart-drawer-empty svg { width: 64px; height: 64px; margin-bottom: 16px; opacity: .4; }
        #sa-cart-drawer-empty p { font-size: 15px; }

        /* Drawer items */
        .sa-drawer-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
            position: relative;
            animation: sa-item-in .3s ease;
        }
        @keyframes sa-item-in {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .sa-drawer-item-img {
            width: 72px; height: 72px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        .sa-drawer-item-img img { width: 100%; height: 100%; object-fit: cover; }
        .sa-drawer-item-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            color: #d1d5db;
        }
        .sa-drawer-item-placeholder svg { width: 28px; height: 28px; }
        .sa-drawer-item-info { flex: 1; min-width: 0; }
        .sa-drawer-item-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0 0 4px 0;
        }
        .sa-drawer-item-price {
            font-size: 14px;
            font-weight: 700;
            color: #0056b3;
            margin: 0 0 8px 0;
        }
        .sa-drawer-item-qty {
            display: inline-flex;
            align-items: center;
            gap: 0;
            background: #f3f4f6;
            border-radius: 8px;
            overflow: hidden;
        }
        .sa-qty-btn {
            width: 30px; height: 30px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            transition: background .15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sa-qty-btn:hover { background: #e5e7eb; }
        .sa-drawer-item-qty span {
            width: 32px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }
        .sa-drawer-item-remove {
            position: absolute;
            top: 14px; right: 0;
            width: 28px; height: 28px;
            border: none;
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background .15s;
        }
        .sa-drawer-item-remove:hover { background: #fee2e2; }
        .sa-drawer-item-remove svg { width: 16px; height: 16px; color: #ef4444; }

        /* Drawer footer */
        #sa-cart-drawer-footer {
            border-top: 1px solid #e5e7eb;
            padding: 20px 24px;
            background: #fafbfc;
        }
        .sa-drawer-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .sa-drawer-total span:first-child {
            font-size: 15px;
            color: #6b7280;
        }
        .sa-drawer-total span:last-child {
            font-size: 20px;
            font-weight: 800;
            color: #111827;
        }
        .sa-checkout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0056b3, #003d80);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }
        .sa-checkout-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0,86,179,.35);
        }
        .sa-checkout-btn svg { width: 18px; height: 18px; }

        /* ─── Add to Cart Button Styles ───────────────────────────── */
        .sa-add-cart-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #0056b3, #003d80);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all .25s;
        }
        .sa-add-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,86,179,.35);
        }
        .sa-add-cart-btn svg { width: 20px; height: 20px; }

        .sa-add-cart-mini {
            position: absolute;
            bottom: 12px;
            right: 12px;
            width: 36px; height: 36px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #0056b3, #003d80);
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,86,179,.3);
            transition: all .25s;
            z-index: 2;
            opacity: 0;
            transform: scale(.8);
        }
        .group:hover .sa-add-cart-mini,
        a.group:hover .sa-add-cart-mini {
            opacity: 1;
            transform: scale(1);
        }
        .sa-add-cart-mini:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 6px 18px rgba(0,86,179,.45);
        }
        .sa-add-cart-mini svg { width: 18px; height: 18px; }

        /* ─── Mobile Menu Styles ──────────────────────────────────── */
        #sa-mobile-menu {
            display: none;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: 12px 16px;
        }
        #sa-mobile-menu.sa-mobile-open { display: block; }
        #sa-mobile-menu a {
            display: block;
            padding: 10px 0;
            color: #374151;
            font-size: 15px;
            text-decoration: none;
            border-bottom: 1px solid #f3f4f6;
        }
        #sa-mobile-menu a:last-child { border-bottom: none; }
        .sa-mobile-submenu {
            padding-left: 16px;
        }
        .sa-mobile-submenu a {
            font-size: 14px !important;
            color: #6b7280 !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                            <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Sahabat Alvaro Logo" class="h-12 w-auto">
                        </a>
                        <div class="hidden md:ml-8 md:flex md:space-x-4">
                            <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:border-blue-500">Beranda</a>
                            
                            <!-- About Dropdown -->
                            <div class="relative group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 cursor-pointer">
                                <span>Tentang Kami</span>
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                <div class="absolute left-0 top-full mt-0 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="py-1">
                                        <a href="{{ route('about.summary') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ringkasan Perusahaan</a>
                                        <a href="{{ route('about.vision_mission') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visi & Misi</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Dropdown -->
                            <div class="relative group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 cursor-pointer">
                                <span>Produk</span>
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                <div class="absolute left-0 top-full mt-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="py-1">
                                        @foreach(\App\Models\Category::all() as $category)
                                            <a href="{{ route('product.category', $category->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('verification.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">Verifikasi Produk</a>
                            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">Artikel Berita</a>
                            <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">FAQ</a>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-3">
                        <!-- Cart Button -->
                        <button class="sa-cart-btn" onclick="window.SACart && SACart.UI.toggleDrawer()" id="sa-cart-btn-desktop" aria-label="Keranjang Belanja">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                            <span class="sa-cart-badge">0</span>
                        </button>
                        <a href="https://wa.me/6285389726874" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-green hover:bg-green-700">
                            Order via WhatsApp
                        </a>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden space-x-2">
                        <!-- Mobile cart button -->
                        <button class="sa-cart-btn" onclick="window.SACart && SACart.UI.toggleDrawer()" aria-label="Keranjang Belanja">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                            <span class="sa-cart-badge">0</span>
                        </button>
                        <button type="button" onclick="document.getElementById('sa-mobile-menu').classList.toggle('sa-mobile-open')" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="sa-mobile-menu">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('about.summary') }}">Ringkasan Perusahaan</a>
                <a href="{{ route('about.vision_mission') }}">Visi & Misi</a>
                @foreach(\App\Models\Category::all() as $category)
                    <a href="{{ route('product.category', $category->slug) }}">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('verification.index') }}">Verifikasi Produk</a>
                <a href="https://wa.me/6285389726874" style="color:#28a745;font-weight:600;">Order via WhatsApp</a>
            </div>
        </nav>

        <!-- Cart Feedback Toast -->
        <div id="sa-cart-feedback">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:18px;height:18px"><path d="M5 13l4 4L19 7"/></svg>
            Ditambahkan ke keranjang!
        </div>

        <!-- Cart Overlay -->
        <div id="sa-cart-overlay" onclick="window.SACart && SACart.UI.toggleDrawer()"></div>

        <!-- Cart Drawer -->
        <div id="sa-cart-drawer">
            <div class="sa-drawer-header">
                <h3>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:22px;height:22px"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    Keranjang Belanja
                </h3>
                <button class="sa-drawer-close" onclick="window.SACart && SACart.UI.toggleDrawer()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="sa-drawer-body">
                <div id="sa-cart-drawer-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    <p>Keranjang masih kosong</p>
                    <p style="font-size:13px;margin-top:4px;">Tambahkan produk untuk mulai belanja</p>
                </div>
                <div id="sa-cart-drawer-items"></div>
            </div>
            <div id="sa-cart-drawer-footer" style="display:none;">
                <div class="sa-drawer-total">
                    <span>Total</span>
                    <span id="sa-cart-drawer-total">Rp 0</span>
                </div>
                <a href="{{ url('/checkout') }}" class="sa-checkout-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                    Checkout Sekarang
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">SAHABAT ALVARO</h3>
                        <p class="text-gray-400 text-sm">Distributor resmi produk farmasi berkualitas tinggi di Indonesia. Kami berkomitmen untuk menyediakan produk asli dan layanan terbaik.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Link Cepat</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                            <li><a href="{{ route('verification.index') }}" class="hover:text-white">Verifikasi Produk</a></li>
                            <li><a href="#" class="hover:text-white">Cek Pengiriman</a></li>
                            <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Kategori</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            @foreach(\App\Models\Category::take(5)->get() as $category)
                                <li><a href="#" class="hover:text-white">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Hubungi Kami</h3>
                        <p class="text-sm text-gray-400">Email: support@sahabatalvaro.store</p>
                        <p class="text-sm text-gray-400">WhatsApp: +62 853-8972-6874</p>
                        <div class="mt-4 flex space-x-4">
                            <!-- Social Media Icons -->
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} Sahabat Alvaro Store. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Cart JS (standalone, no Vite build needed) -->
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('scripts')
</body>
</html>
