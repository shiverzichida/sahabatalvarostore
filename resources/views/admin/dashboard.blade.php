@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-gray-500 text-sm font-medium">Total Produk</h3>
        <p class="text-3xl font-bold mt-2 text-primary-blue">{{ $productCount }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-gray-500 text-sm font-medium">Total Kategori</h3>
        <p class="text-3xl font-bold mt-2 text-green-600">{{ $categoryCount }}</p>
    </div>
</div>
@endsection
