@extends('layouts.app')

@section('title', $category->name . ' - Sahabat Alvaro Store')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">{{ $category->name }}</h1>
            <p class="mt-4 text-lg text-gray-500">Koleksi produk farmasi terbaik dalam kategori {{ $category->name }}.</p>
        </div>

        @if($products->count() > 0)
        <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @foreach($products as $product)
            <div class="group bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition relative">
                <a href="{{ route('product.show', $product->slug) }}">
                    <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden relative">
                        <img src="{{ $product->image ? url('product-images/' . $product->image) : 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover group-hover:opacity-75">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900">{{ $product->name }}</h3>
                        <p class="mt-1 text-lg font-bold text-primary-blue">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
                <!-- Mini add-to-cart button -->
                <button class="sa-add-cart-mini"
                    onclick="event.preventDefault(); event.stopPropagation(); window.SACart && SACart.addItem({id:{{ $product->id }}, name:'{{ addslashes($product->name) }}', slug:'{{ $product->slug }}', price:{{ $product->price }}, image:'{{ $product->image ? url('product-images/' . $product->image) : '' }}', qty:1})"
                    title="Tambah ke Keranjang"
                    style="bottom:72px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                </button>
            </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-lg shadow-sm">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
            <p class="mt-1 text-sm text-gray-500">Kategori ini sedang kosong, silakan cek kembali nanti.</p>
        </div>
        @endif
    </div>
</div>
@endsection
