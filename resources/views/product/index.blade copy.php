@extends('layouts.master')

@section('title')
    SIMS | Produk
@endsection

@section('product-active')
    active
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-0 mb-3">Daftar Produk</h2>

        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex mb-3">
                <div class="input-group flex-grow-1 me-4">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="search" class="form-control" placeholder="Masukkan kata kunci">
                </div>
                <select id="category" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button class="btn btn-success me-3">Export to Excel</button>
                <a href="{{ url('/products/create') }}" class="btn btn-danger">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Produk
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Nama Produk</th>
                            <th>Kategori Produk</th>
                            <th>Harga Beli (Rp)</th>
                            <th>Harga Jual (Rp)</th>
                            <th>Stok Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Nama Produk</th>
                            <th>Kategori Produk</th>
                            <th>Harga Beli (Rp)</th>
                            <th>Harga Jual (Rp)</th>
                            <th>Stok Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <th>{{ $loop->iteration }}.</th>
                                <td>
                                    <img src="{{ asset($item->image_path) }}" width="50" alt="{{ $item->image_path }}">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ number_format($item->buy_price) }}</td>
                                <td>{{ number_format($item->sell_price) }}</td>
                                <td>{{ number_format($item->stock) }}</td>
                                <td>
                                    <a href="{{ url('products/' . $item->id . '/edit') }}" class="text-primary me-3">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="{{ url('products/' . $item->id . '/delete') }}"
                                        onclick="return confirm('Anda yakin ingin menghapus produk?')" class="text-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
