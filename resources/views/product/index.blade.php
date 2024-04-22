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
                    <span class="input-group-text" id="search-icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Masukkan kata kunci">
                </div>
                <select id="category" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex align-items-center">
                <form action="{{ url('products/export-to-excel') }}" method="post" class="me-3">
                    @csrf

                    <input type="hidden" name="filter" value="{{ $search }}">

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </form>
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
                Daftar Produk
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
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
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}.</th>
                                    <td>
                                        <img src="{{ asset($item->image_path) }}" width="50"
                                            alt="{{ $item->image_path }}">
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
                                            onclick="return confirm('Anda yakin ingin menghapus produk?')"
                                            class="text-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0">
                            Show {{ $products->lastItem() }} from {{ $products->total() }}
                        </p>
                        <div class="pagination">
                            <ul class="pagination">
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $products->previousPageUrl() }}">&laquo;</a></li>
                                @endif

                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active" aria-current="page"><span
                                                class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                @if ($products->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $products->nextPageUrl() }}">&raquo;</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        // Tangani klik pada ikon pencarian
        document.getElementById('search-icon').addEventListener('click', function() {
            processSearch();
        });

        // Tangani tekan tombol enter pada input teks
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                processSearch();
            }
        });

        // Fungsi untuk memproses pencarian
        function processSearch() {
            var searchKeyword = document.getElementById('search').value;
            var url;

            if (searchKeyword.trim() === '') {
                url = '{{ url('/products') }}'; // Jika input pencarian kosong
            } else {
                url = '{{ url('/products') }}'; // Jika input pencarian tidak kosong
            }

            // Redirect ke halaman pencarian atau halaman produk
            window.location.href = url + '?search=' + searchKeyword;
        }
    </script>
@endsection
