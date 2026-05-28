@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')

@section('css')
<style>
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255,255,255,0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .price-input-container { position: relative; }
    .price-display {
        font-size: 0.8rem;
        color: #28a745;
        position: absolute;
        bottom: -18px;
        left: 5px;
    }
</style>
@endsection

@section('content')
<div id="loading" class="loading-overlay">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status"></div>
        <div class="mt-2 font-weight-bold">Memproses Data...</div>
    </div>
</div>

<div class="row">
    <!-- Batch Add Section -->
    <div class="col-md-12 mb-3">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Input Banyak Produk (Batch)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-success" onclick="addRow()">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>
            </div>
            <form action="{{ route('admin.products.batch-store') }}" method="POST" onsubmit="showLoading()">
                @csrf
                <div class="card-body p-0">
                    <table class="table table-sm border-bottom" id="batch-table">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th style="width: 180px">Kategori</th>
                                <th style="width: 180px">Harga (IDR)</th>
                                <th>Deskripsi</th>
                                <th style="width: 50px"></th>
                            </tr>
                        </thead>
                        <tbody id="batch-body">
                            <tr>
                                <td><input type="text" name="products[0][name]" class="form-control form-control-sm" required></td>
                                <td>
                                    <select name="products[0][category_id]" class="form-control form-control-sm" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="price-input-container">
                                    <input type="text" name="products[0][price_formatted]" class="form-control form-control-sm price-input-mask" required>
                                    <input type="hidden" name="products[0][price]" class="price-actual">
                                </td>
                                <td><input type="text" name="products[0][description]" class="form-control form-control-sm"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary px-5">SIMPAN SEMUA PRODUK</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Table -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Produk</h3>
                <div class="card-tools">
                    <form action="{{ route('admin.products.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="Cari Nama/Kategori..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="width: 60px">Foto</th>
                            <th style="width: 200px">Nama Produk</th>
                            <th style="width: 150px">Kategori</th>
                            <th style="width: 150px">Harga (IDR)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="align-middle">
                                <div class="product-img-editable" onclick="document.getElementById('img-input-{{ $product->id }}').click()">
                                    <img src="{{ $product->image ? url('product-images/' . $product->image) : 'https://via.placeholder.com/50?text=No+Img' }}" 
                                         class="img-thumbnail" style="width: 45px; height: 45px; object-fit: cover;">
                                </div>
                                <form action="{{ route('admin.products.update-image', $product) }}" method="POST" enctype="multipart/form-data" style="display:none" onsubmit="showLoading()">
                                    @csrf @method('PATCH')
                                    <input type="file" name="image" id="img-input-{{ $product->id }}" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="align-middle">
                                <input type="text" class="form-control form-control-sm quick-update-name" data-id="{{ $product->id }}" name="name" value="{{ $product->name }}">
                            </td>
                            <td class="align-middle">
                                <select class="form-control form-control-sm quick-update" data-id="{{ $product->id }}" name="category_id">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="align-middle">
                                <div class="price-input-container">
                                    <input type="text" class="form-control form-control-sm quick-update-price price-input-mask" data-id="{{ $product->id }}" name="price_formatted" value="{{ number_format($product->price, 0, ',', '.') }}">
                                    <input type="hidden" class="price-actual" name="price" value="{{ (int)$product->price }}">
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.duplicate', $product) }}" class="btn btn-info btn-xs" onclick="showLoading()">
                                        <i class="fas fa-copy"></i> Copy
                                    </a>
                                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#editModal{{ $product->id }}">
                                        <i class="fas fa-edit"></i> Deskripsi
                                    </button>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus?'); showLoading();">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>

                                <!-- Full Edit Modal (Mainly for Description now) -->
                                <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.products.update', $product) }}" method="POST" onsubmit="showLoading()">
                                                @csrf @method('PUT')
                                                <div class="modal-header"><h5>Edit Deskripsi & Detail</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                                                <div class="modal-body text-left">
                                                    <div class="row">
                                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                                        <input type="hidden" name="price" value="{{ (int)$product->price }}">
                                                        <div class="col-md-12 form-group"><label>Deskripsi Produk</label><textarea name="description" class="form-control" rows="6">{{ $product->description }}</textarea></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Deskripsi</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
let rowIndex = 1;

function addRow() {
    let html = `
    <tr>
        <td><input type="text" name="products[${rowIndex}][name]" class="form-control form-control-sm" required></td>
        <td>
            <select name="products[${rowIndex}][category_id]" class="form-control form-control-sm" required>
                @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
            </select>
        </td>
        <td class="price-input-container">
            <input type="text" name="products[${rowIndex}][price_formatted]" class="form-control form-control-sm price-input-mask" required>
            <input type="hidden" name="products[${rowIndex}][price]" class="price-actual">
        </td>
        <td><input type="text" name="products[${rowIndex}][description]" class="form-control form-control-sm"></td>
        <td class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="$(this).closest('tr').remove()"><i class="fas fa-times"></i></button></td>
    </tr>`;
    $('#batch-body').append(html);
    rowIndex++;
}

function showLoading() { $('#loading').css('display', 'flex'); }

$(document).ready(function() {
    // Digit Separator Logic
    $(document).on('input', '.price-input-mask', function() {
        let val = $(this).val().replace(/\D/g, "");
        let actualVal = parseInt(val) || 0;
        $(this).siblings('.price-actual').val(actualVal);
        $(this).val(actualVal.toLocaleString('id-ID'));
    });

    // Instant Update Generic (Category, Name)
    $(document).on('change', '.quick-update, .quick-update-name', function() {
        let id = $(this).data('id');
        let name = $(this).attr('name');
        let val = $(this).val();
        
        showLoading();
        $.ajax({
            url: `/admin/products/${id}/quick-update`,
            method: 'PATCH',
            data: { _token: '{{ csrf_token() }}', [name]: val },
            success: function() { $('#loading').hide(); },
            error: function() { $('#loading').hide(); alert('Gagal update data'); }
        });
    });

    // Instant Update Price
    $(document).on('focusout', '.quick-update-price', function() {
        let id = $(this).data('id');
        let actualVal = $(this).siblings('.price-actual').val();
        
        showLoading();
        $.ajax({
            url: `/admin/products/${id}/quick-update`,
            method: 'PATCH',
            data: { _token: '{{ csrf_token() }}', price: actualVal },
            success: function() { $('#loading').hide(); },
            error: function() { $('#loading').hide(); alert('Gagal update harga'); }
        });
    });
});
</script>
@endsection
