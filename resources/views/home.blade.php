@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Authorized Main Distributor</span>
                        <span class="block primary-blue xl:inline">in Indonesia</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Kami adalah distributor resmi nomor 1 di Indonesia untuk berbagai produk farmasi berkualitas tinggi. Pastikan keaslian produk Anda melalui sistem verifikasi kami.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('verification.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-blue hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                Verifikasi Produk
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg md:px-10">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{ asset('images/background.jpeg') }}" alt="Authorized Main Distributor">
    </div>
</div>

<!-- Gallery Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Galeri Produk Kami</h2>
            <p class="mt-4 text-lg text-gray-500">Lihat lebih dekat kualitas produk unggulan yang kami tawarkan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="rounded-lg overflow-hidden shadow-lg border border-gray-200 group bg-gray-100 flex items-center justify-center">
                <img src="{{ asset('images/a.jpeg') }}" alt="Gallery Image 1" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500">
            </div>

            <div class="rounded-lg overflow-hidden shadow-lg border border-gray-200 group bg-gray-100 flex items-center justify-center">
                <img src="{{ asset('images/b.jpeg') }}" alt="Gallery Image 2" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500">
            </div>

            <div class="rounded-lg overflow-hidden shadow-lg border border-gray-200 group bg-gray-100 flex items-center justify-center">
                <img src="{{ asset('images/c.jpg') }}" alt="Gallery Image 3" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500">
            </div>

            <div class="rounded-lg overflow-hidden shadow-lg border border-gray-200 group bg-gray-100 flex items-center justify-center">
                <img src="{{ asset('images/d.jpeg') }}" alt="Gallery Image 4" class="w-full h-64 object-contain transform group-hover:scale-105 transition duration-500">
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Kategori Produk</h2>
            <p class="mt-4 text-lg text-gray-500">Temukan berbagai solusi kesehatan berdasarkan kategori yang kami sediakan.</p>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach(\App\Models\Category::all() as $category)
            <div class="group relative bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-6 w-6 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                <a href="{{ route('product.category', $category->slug) }}" class="mt-2 block text-sm font-semibold primary-blue hover:text-blue-700">Lihat Semua &rarr;</a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Verification Banner -->
<div class="bg-primary-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Keaslian Produk Terjamin</h2>
        <p class="mt-4 text-xl text-blue-100">Beli dengan percaya diri. Gunakan kode verifikasi pada kemasan untuk memastikan produk Anda asli.</p>
        <div class="mt-8">
            <a href="{{ route('verification.index') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-blue bg-white hover:bg-gray-100 md:text-lg">
                Cek Kode Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
