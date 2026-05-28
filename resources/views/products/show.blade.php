@extends('layouts.app')

@section('title', $product->name . ' - Sahabat Alvaro Store')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-sm text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-primary-blue">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('product.category', $product->category->slug) }}" class="hover:text-primary-blue">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            <!-- Product Image -->
            <div class="flex flex-col">
                <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                    <img src="{{ $product->image ? url('product-images/' . $product->image) : 'https://via.placeholder.com/600' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover" id="product-main-image">
                </div>
            </div>

            <!-- Product Details -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                
                <div class="mt-3">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl text-primary-blue font-bold">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900">Kategori</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $product->category->name }}</p>
                </div>

                <!-- Quantity Selector -->
                <div class="mt-8">
                    <label class="text-sm font-medium text-gray-900 block mb-2">Jumlah</label>
                    <div class="sa-drawer-item-qty" style="display:inline-flex; border: 1px solid #e5e7eb; border-radius: 10px;">
                        <button class="sa-qty-btn" onclick="updateProductQty(-1)" style="width:40px;height:40px;font-size:18px;">−</button>
                        <span id="sa-product-qty" style="width:48px;line-height:40px;font-size:16px;">1</span>
                        <button class="sa-qty-btn" onclick="updateProductQty(1)" style="width:40px;height:40px;font-size:18px;">+</button>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <!-- Add to Cart Button -->
                    <button onclick="addThisToCart()" class="sa-add-cart-btn flex-1" style="padding:14px 24px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                        Tambah ke Keranjang
                    </button>

                    @php
                        $waMessage = "Halo Sahabat Alvaro, saya tertarik untuk memesan produk: " . $product->name . ". Mohon info detailnya.";
                        $waUrl = "https://wa.me/6285389726874?text=" . urlencode($waMessage);
                    @endphp
                    <a href="{{ $waUrl }}" target="_blank" class="flex-1 bg-primary-green border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-green-700 focus:outline-none transition">
                        Order via WhatsApp
                    </a>
                </div>

                <section aria-labelledby="details-heading" class="mt-12 border-t border-gray-200 pt-8">
                    <h2 id="details-heading" class="text-lg font-bold text-gray-900">Deskripsi Produk</h2>
                    <div class="mt-4 prose prose-sm text-gray-500 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </section>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-24 border-t border-gray-200 pt-16">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Produk Terkait</h2>
            <div class="mt-10 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach($relatedProducts as $related)
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none relative">
                        <img src="{{ $related->image ? url('product-images/' . $related->image) : 'https://via.placeholder.com/400' }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        <button class="sa-add-cart-mini"
                            onclick="event.preventDefault(); event.stopPropagation(); window.SACart && SACart.addItem({id:{{ $related->id }}, name:'{{ addslashes($related->name) }}', slug:'{{ $related->slug }}', price:{{ $related->price }}, image:'{{ $related->image ? url('product-images/' . $related->image) : '' }}', qty:1})"
                            title="Tambah ke Keranjang">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                        </button>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="{{ route('product.show', $related->slug) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $related->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $related->category->name }}</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">IDR {{ number_format($related->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    let productQty = 1;
    function updateProductQty(delta) {
        productQty = Math.max(1, productQty + delta);
        document.getElementById('sa-product-qty').textContent = productQty;
    }
    function addThisToCart() {
        if (!window.SACart) return;
        SACart.addItem({
            id: {{ $product->id }},
            name: '{{ addslashes($product->name) }}',
            slug: '{{ $product->slug }}',
            price: {{ $product->price }},
            image: '{{ $product->image ? url("product-images/" . $product->image) : "" }}',
            qty: productQty
        });
    }
</script>
@endpush
@endsection
