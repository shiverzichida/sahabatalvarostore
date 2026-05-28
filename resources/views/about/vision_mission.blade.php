@extends('layouts.app')

@section('title', 'Visi & Misi - Sahabat Alvaro Store')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center mb-16">
            <h2 class="text-base text-primary-blue font-semibold tracking-wide uppercase">Tujuan Kami</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Visi & Misi
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-white p-8 rounded-lg shadow-sm">
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="h-6 w-6 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi</h3>
                <p class="text-gray-500 text-lg leading-relaxed">
                    Menjadi distributor farmasi paling terpercaya di Indonesia yang dikenal karena keaslian produk, integritas layanan, dan kontribusi nyata dalam meningkatkan kualitas hidup masyarakat melalui solusi kesehatan yang inovatif dan terjangkau.
                </p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-sm">
                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="h-6 w-6 text-primary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi</h3>
                <ul class="space-y-4 text-gray-500 text-lg">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-2 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Menyediakan produk farmasi asli dan berkualitas tinggi langsung dari produsen resmi.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-2 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Membangun sistem distribusi yang efisien dan aman untuk menjangkau seluruh wilayah Indonesia.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-2 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Mengedukasi masyarakat tentang pentingnya keaslian produk kesehatan dan cara verifikasinya.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-2 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Memberikan layanan pelanggan yang responsif, transparan, dan profesional.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
