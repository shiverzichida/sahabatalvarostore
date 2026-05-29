@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-black overflow-hidden border-b border-white/5">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-20 pb-8 bg-transparent sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-5xl tracking-tight font-black uppercase text-white sm:text-6xl md:text-7xl font-sporty">
                        <span class="block">Authorized Main</span>
                        <span class="block text-red-500">Distributor</span>
                        <span class="block text-white text-3xl sm:text-4xl md:text-5xl mt-2 tracking-normal font-sans font-light lowercase italic">in Indonesia</span>
                    </h1>
                    <p class="mt-5 text-base text-gray-400 sm:mt-6 sm:text-lg sm:max-w-xl sm:mx-auto md:text-xl lg:mx-0 font-light">
                        Kami adalah distributor resmi nomor 1 di Indonesia untuk berbagai produk farmasi berkualitas tinggi. Pastikan keaslian produk Anda melalui sistem verifikasi kami.
                    </p>
                    
                    <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('product.index') }}" class="w-full flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold uppercase rounded-md text-white bg-red-600 hover:bg-red-700 transition md:py-4 md:text-lg md:px-10">
                                Lihat Produk
                            </a>
                        </div>
                        
                        @auth
                            <div class="rounded-md shadow-sm">
                                <a href="{{ route('client.dashboard') }}" class="w-full flex items-center justify-center px-8 py-3.5 border border-white/10 text-base font-semibold rounded-md text-white bg-white/5 hover:bg-white/10 md:py-4 md:text-lg md:px-10 transition">
                                    Dashboard Saya &rarr;
                                </a>
                            </div>
                        @else
                            <div class="flex flex-row gap-3 w-full sm:w-auto">
                                <a href="{{ route('login') }}" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-3.5 border border-white/10 text-base font-semibold rounded-md text-gray-300 bg-white/5 hover:bg-white/10 md:py-4 md:text-lg md:px-8 transition">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-3.5 border border-red-600 text-base font-semibold rounded-md text-red-500 bg-red-950/20 hover:bg-red-950/40 md:py-4 md:text-lg md:px-8 transition">
                                    Daftar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Hero Image with Fade Overlays -->
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 relative h-64 sm:h-80 md:h-96 lg:h-full">
        <!-- Gradients to blend image into the dark page background -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#080808] via-transparent to-transparent z-10 hidden lg:block"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#080808] via-[#080808]/20 to-transparent z-10 lg:hidden"></div>
        <img class="h-full w-full object-cover opacity-60 filter grayscale contrast-125 brightness-75" src="{{ asset('images/background.jpeg') }}" alt="Authorized Main Distributor">
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
