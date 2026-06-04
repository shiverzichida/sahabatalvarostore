@extends('layouts.app')

@section('content')
<!-- Hero Carousel Section -->
<div class="sa-carousel-container relative border-b border-white/5">
    <!-- Vertical Dot Indicators -->
    <div class="sa-carousel-indicators">
        <button class="sa-carousel-dot active" data-slide="0" aria-label="Slide 1"></button>
        <button class="sa-carousel-dot" data-slide="1" aria-label="Slide 2"></button>
        <button class="sa-carousel-dot" data-slide="2" aria-label="Slide 3"></button>
        <button class="sa-carousel-dot" data-slide="3" aria-label="Slide 4"></button>
    </div>

    <!-- Slides Wrapper -->
    <div class="sa-carousel-wrapper" id="saCarouselWrapper">
        <!-- Slide 1 -->
        <div class="sa-carousel-slide min-h-[580px] sm:min-h-[620px] lg:min-h-0 lg:h-auto py-8 pb-20 sm:py-12 sm:pb-24 lg:py-24">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 w-full grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center h-full lg:pl-24">
                <div class="text-center lg:text-left order-2 lg:order-1 flex flex-col justify-center">
                    <span class="text-red-500 font-bold uppercase tracking-wider text-xs sm:text-sm block mb-1.5 lg:mb-2">Authorized Number 1 Distributor</span>
                    <h1 class="text-3.5xl sm:text-5xl lg:text-7.5xl tracking-tight font-black uppercase text-white font-sporty leading-none mb-3 lg:mb-4">
                        Every Serving<br><span class="text-red-500">Proves It.</span>
                    </h1>
                    <p class="text-xs sm:text-base text-gray-400 max-w-xl mb-6 lg:mb-8 font-light mx-auto lg:mx-0">
                        Kami adalah distributor resmi nomor 1 di Indonesia untuk berbagai produk farmasi berkualitas tinggi. Pastikan keaslian produk Anda melalui sistem verifikasi kami.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <div class="w-full sm:w-auto">
                            <a href="{{ route('product.index') }}" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm sm:text-base font-bold uppercase rounded-md text-white bg-red-600 hover:bg-red-700 transition lg:py-4 lg:px-10">
                                Lihat Produk
                            </a>
                        </div>
                        
                        @auth
                            <div class="w-full sm:w-auto">
                                <a href="{{ route('client.dashboard') }}" class="w-full inline-flex items-center justify-center px-6 py-3 border border-white/10 text-sm sm:text-base font-semibold rounded-md text-white bg-white/5 hover:bg-white/10 transition lg:py-4 lg:px-10">
                                    Dashboard Saya &rarr;
                                </a>
                            </div>
                        @else
                            <div class="flex flex-row gap-3 w-full sm:w-auto justify-center lg:justify-start">
                                <a href="{{ route('login') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-3 border border-white/10 text-sm sm:text-base font-semibold rounded-md text-gray-300 bg-white/5 hover:bg-white/10 transition lg:py-4 lg:px-8">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-3 border border-red-600 text-sm sm:text-base font-semibold rounded-md text-red-500 bg-red-950/20 hover:bg-red-950/40 transition lg:py-4 lg:px-8">
                                    Daftar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="flex justify-center relative order-1 lg:order-2 h-56 sm:h-72 lg:h-auto w-full">
                    <!-- Glow effect under the product -->
                    <div class="absolute w-56 h-56 sm:w-72 sm:h-72 bg-red-600/10 rounded-full filter blur-3xl z-0 pointer-events-none"></div>
                    <img class="h-full lg:h-[450px] object-contain relative z-10 drop-shadow-[0_20px_50px_rgba(239,68,68,0.25)] transition duration-500 transform hover:scale-105 filter brightness-95" src="{{ asset('images/a.jpeg') }}" alt="Product Photo A">
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="sa-carousel-slide min-h-[580px] sm:min-h-[620px] lg:min-h-0 lg:h-auto py-8 pb-20 sm:py-12 sm:pb-24 lg:py-24">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 w-full grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center h-full lg:pl-24">
                <div class="text-center lg:text-left order-2 lg:order-1 flex flex-col justify-center">
                    <span class="text-red-500 font-bold uppercase tracking-wider text-xs sm:text-sm block mb-1.5 lg:mb-2">Uncompromising Standards</span>
                    <h1 class="text-3.5xl sm:text-5xl lg:text-7.5xl tracking-tight font-black uppercase text-white font-sporty leading-none mb-3 lg:mb-4">
                        Science Backed<br><span class="text-red-500">Formulas.</span>
                    </h1>
                    <p class="text-xs sm:text-base text-gray-400 max-w-xl mb-6 lg:mb-8 font-light mx-auto lg:mx-0">
                        Setiap produk yang kami distribusikan melewati uji laboratorium ketat untuk menjamin kemurnian dan efisiensi penyerapan maksimal bagi hasil terbaik Anda.
                    </p>
                    <div class="flex justify-center lg:justify-start">
                        <a href="{{ route('verification.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm sm:text-base font-bold uppercase rounded-md text-white bg-red-600 hover:bg-red-700 transition lg:py-4 lg:px-10">
                            Cek Keaslian Produk
                        </a>
                    </div>
                </div>
                <div class="flex justify-center relative order-1 lg:order-2 h-56 sm:h-72 lg:h-auto w-full">
                    <div class="absolute w-56 h-56 sm:w-72 sm:h-72 bg-red-600/10 rounded-full filter blur-3xl z-0 pointer-events-none"></div>
                    <img class="h-full lg:h-[450px] object-contain relative z-10 drop-shadow-[0_20px_50px_rgba(239,68,68,0.25)] transition duration-500 transform hover:scale-105 filter brightness-95" src="{{ asset('images/b.jpeg') }}" alt="Product Photo B">
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="sa-carousel-slide min-h-[580px] sm:min-h-[620px] lg:min-h-0 lg:h-auto py-8 pb-20 sm:py-12 sm:pb-24 lg:py-24">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 w-full grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center h-full lg:pl-24">
                <div class="text-center lg:text-left order-2 lg:order-1 flex flex-col justify-center">
                    <span class="text-red-500 font-bold uppercase tracking-wider text-xs sm:text-sm block mb-1.5 lg:mb-2">Maximum Muscle & Power</span>
                    <h1 class="text-3.5xl sm:text-5xl lg:text-7.5xl tracking-tight font-black uppercase text-white font-sporty leading-none mb-3 lg:mb-4">
                        Reach Your<br><span class="text-red-500">True Potential.</span>
                    </h1>
                    <p class="text-xs sm:text-base text-gray-400 max-w-xl mb-6 lg:mb-8 font-light mx-auto lg:mx-0">
                        Tingkatkan performa latihan dan capai target fisik ideal Anda dengan dukungan konsultasi program dari tim ahli kami.
                    </p>
                    <div class="flex justify-center lg:justify-start">
                        <a href="https://wa.me/6285389726874" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm sm:text-base font-bold uppercase rounded-md text-white bg-red-600 hover:bg-red-700 transition lg:py-4 lg:px-10">
                            Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>
                <div class="flex justify-center relative order-1 lg:order-2 h-56 sm:h-72 lg:h-auto w-full">
                    <div class="absolute w-56 h-56 sm:w-72 sm:h-72 bg-red-600/10 rounded-full filter blur-3xl z-0 pointer-events-none"></div>
                    <img class="h-full lg:h-[450px] object-contain relative z-10 drop-shadow-[0_20px_50px_rgba(239,68,68,0.25)] transition duration-500 transform hover:scale-105 filter brightness-95" src="{{ asset('images/c.jpg') }}" alt="Product Photo C">
                </div>
            </div>
        </div>

        <!-- Slide 4 -->
        <div class="sa-carousel-slide min-h-[580px] sm:min-h-[620px] lg:min-h-0 lg:h-auto py-8 pb-20 sm:py-12 sm:pb-24 lg:py-24">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 w-full grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center h-full lg:pl-24">
                <div class="text-center lg:text-left order-2 lg:order-1 flex flex-col justify-center">
                    <span class="text-red-500 font-bold uppercase tracking-wider text-xs sm:text-sm block mb-1.5 lg:mb-2">Fast, Safe & Secure Delivery</span>
                    <h1 class="text-3.5xl sm:text-5xl lg:text-7.5xl tracking-tight font-black uppercase text-white font-sporty leading-none mb-3 lg:mb-4">
                        Secure &<br><span class="text-red-500">Safe Shipping.</span>
                    </h1>
                    <p class="text-xs sm:text-base text-gray-400 max-w-xl mb-6 lg:mb-8 font-light mx-auto lg:mx-0">
                        Kami mengemas pesanan Anda dengan proteksi ekstra untuk menjamin keamanan hingga sampai ke depan pintu rumah Anda.
                    </p>
                    <div class="flex justify-center lg:justify-start">
                        <a href="{{ route('product.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm sm:text-base font-bold uppercase rounded-md text-white bg-red-600 hover:bg-red-700 transition lg:py-4 lg:px-10">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
                <div class="flex justify-center relative order-1 lg:order-2 h-56 sm:h-72 lg:h-auto w-full">
                    <div class="absolute w-56 h-56 sm:w-72 sm:h-72 bg-red-600/10 rounded-full filter blur-3xl z-0 pointer-events-none"></div>
                    <img class="h-full lg:h-[450px] object-contain relative z-10 drop-shadow-[0_20px_50px_rgba(239,68,68,0.25)] transition duration-500 transform hover:scale-105 filter brightness-95" src="{{ asset('images/d.jpeg') }}" alt="Product Photo D">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trust Badges Section -->
<div class="bg-black border-b border-white/5 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="flex flex-col items-center justify-center p-4">
                <div class="h-14 w-14 bg-red-950/20 border border-red-500/20 rounded-full flex items-center justify-center mb-4 text-red-500">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h4 class="text-white font-bold uppercase text-sm tracking-wider font-sporty">100% Produk Original</h4>
                <p class="text-xs text-gray-500 mt-1">Distributor resmi terverifikasi</p>
            </div>
            <div class="flex flex-col items-center justify-center p-4">
                <div class="h-14 w-14 bg-red-950/20 border border-red-500/20 rounded-full flex items-center justify-center mb-4 text-red-500">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h4 class="text-white font-bold uppercase text-sm tracking-wider font-sporty">Teruji Lab & Aman</h4>
                <p class="text-xs text-gray-500 mt-1">Bebas zat berbahaya & bersertifikat</p>
            </div>
            <div class="flex flex-col items-center justify-center p-4">
                <div class="h-14 w-14 bg-red-950/20 border border-red-500/20 rounded-full flex items-center justify-center mb-4 text-red-500">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h4 class="text-white font-bold uppercase text-sm tracking-wider font-sporty">Pengiriman Cepat</h4>
                <p class="text-xs text-gray-500 mt-1">Layanan instant & sameday aktif</p>
            </div>
            <div class="flex flex-col items-center justify-center p-4">
                <div class="h-14 w-14 bg-red-950/20 border border-red-500/20 rounded-full flex items-center justify-center mb-4 text-red-500">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h4 class="text-white font-bold uppercase text-sm tracking-wider font-sporty">Konsultasi Ahli</h4>
                <p class="text-xs text-gray-500 mt-1">Panduan pemakaian oleh tim ahli</p>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Section -->
<div class="bg-[#0a0a0a] py-20 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold uppercase text-white font-sporty tracking-wider sm:text-5xl">Galeri Produk Kami</h2>
            <p class="mt-4 text-lg text-gray-400">Lihat lebih dekat kualitas produk unggulan yang kami tawarkan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="rounded-xl overflow-hidden shadow-2xl border border-white/5 group bg-[#111111] flex items-center justify-center p-4">
                <img src="{{ asset('images/a.jpeg') }}" alt="Gallery Image 1" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500 filter brightness-95">
            </div>

            <div class="rounded-xl overflow-hidden shadow-2xl border border-white/5 group bg-[#111111] flex items-center justify-center p-4">
                <img src="{{ asset('images/b.jpeg') }}" alt="Gallery Image 2" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500 filter brightness-95">
            </div>

            <div class="rounded-xl overflow-hidden shadow-2xl border border-white/5 group bg-[#111111] flex items-center justify-center p-4">
                <img src="{{ asset('images/c.jpg') }}" alt="Gallery Image 3" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500 filter brightness-95">
            </div>

            <div class="rounded-xl overflow-hidden shadow-2xl border border-white/5 group bg-[#111111] flex items-center justify-center p-4">
                <img src="{{ asset('images/d.jpeg') }}" alt="Gallery Image 4" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500 filter brightness-95">
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-black py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold uppercase text-white font-sporty tracking-wider sm:text-5xl">Kategori Produk</h2>
            <p class="mt-4 text-lg text-gray-400">Temukan berbagai solusi kebugaran berdasarkan kategori yang kami sediakan.</p>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach(\App\Models\Category::all() as $category)
            <div class="sa-glass-card group relative rounded-xl p-6 flex flex-col justify-between min-h-[180px]">
                <div>
                    <div class="h-12 w-12 bg-red-950/30 border border-red-500/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold uppercase text-white tracking-wide font-sporty">{{ $category->name }}</h3>
                </div>
                <a href="{{ route('product.category', $category->slug) }}" class="mt-4 block text-sm font-bold uppercase text-red-500 group-hover:text-red-400 transition">
                    Lihat Produk &rarr;
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Verification Banner -->
<div class="relative bg-gradient-to-r from-red-950/40 via-[#0a0a0a] to-red-950/40 border-y border-white/5 py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-red-900/10 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl font-black uppercase text-white sm:text-5xl font-sporty tracking-wider">
            Keaslian Produk <span class="text-red-500">Terjamin 100%</span>
        </h2>
        <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto font-light leading-relaxed">
            Beli dengan percaya diri penuh. Gunakan kode unik verifikasi pada segel kemasan produk untuk memastikan keaslian distributor resmi Sahabat Alvaro.
        </p>
        <div class="mt-10">
            <a href="{{ route('verification.index') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-base font-bold uppercase rounded-md text-white bg-red-600 hover:bg-red-700 transition shadow-lg shadow-red-600/20 md:text-lg tracking-wider">
                Verifikasi Kode Anda
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('saCarouselWrapper');
        const dots = document.querySelectorAll('.sa-carousel-dot');
        const slideCount = dots.length;
        let currentSlide = 0;
        let autoplayInterval;

        function showSlide(index) {
            currentSlide = (index + slideCount) % slideCount;
            wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update dots
            dots.forEach((dot, idx) => {
                if (idx === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function startAutoplay() {
            stopAutoplay();
            autoplayInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 6000); // 6 seconds per slide
        }

        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
            }
        }

        // Dot click handlers
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const slideIndex = parseInt(dot.getAttribute('data-slide'));
                showSlide(slideIndex);
                startAutoplay(); // Reset autoplay timer on manual click
            });
        });

        // Touch swipe support for mobile
        let startX = 0;
        let endX = 0;
        const threshold = 50;

        wrapper.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            stopAutoplay();
        }, { passive: true });

        wrapper.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;

            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    // Swipe left -> next slide
                    showSlide(currentSlide + 1);
                } else {
                    // Swipe right -> prev slide
                    showSlide(currentSlide - 1);
                }
            }
            startAutoplay();
        }, { passive: true });

        // Start autoplay initially
        startAutoplay();
    });
</script>
@endpush
