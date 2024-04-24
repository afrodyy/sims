@extends('layouts.master')

@section('title')
    SIMS | Produk - Edit
@endsection

@section('product-active')
    active
@endsection

@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/products') }}">Daftar Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
            </ol>
        </nav>

        <h2 class="mt-0 mb-3">Edit Data Produk</h2>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ url('products/' . $product->id . '/update') }}" class="row g-3" id="product-form"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4">
                        <label for="category" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" name="category" id="category" required>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" @if ($item->id === $product->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="name" class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ $product->name }}" placeholder="Masukkan nama barang" required>
                    </div>
                    <div class="col-md-4">
                        <label for="buy_price" class="form-label">Harga Beli</label>
                        <input type="text" class="form-control" name="buy_price" id="buy_price"
                            value="{{ $product->buy_price }}" placeholder="Masukkan harga beli" required>
                    </div>
                    <div class="col-md-4">
                        <label for="sell_price" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control" name="sell_price" id="sell_price"
                            value="{{ $product->sell_price }}" placeholder="Masukkan harga jual" required>
                    </div>
                    <div class="col-md-4">
                        <label for="stock" class="form-label">Stok Barang</label>
                        <input type="text" class="form-control" name="stock" id="stock"
                            value="{{ $product->stock }}" placeholder="Masukkan jumlah stok barang" required>
                    </div>
                    <div class="col-12">
                        {{-- View image from local server --}}
                        {{-- <img src="{{ asset($product->image_path) }}" width="200" class="img-thumbnail"
                            alt="{{ $product->image_path }}"><br /> --}}

                        {{-- View image from cloudinary --}}
                        <img src="{{ $product->image_path }}" width="200" class="img-thumbnail"
                            alt="{{ $product->image_path }}"><br />
                        <label for="image" class="form-label">Image</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="image" id="image" />
                            {{-- <p class="help-block">{{ $errors->first('image') }}</p> --}}
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-primary">Batalkan</button>
                        <button type="submit" class="btn btn-primary ms-4"
                            onclick="submitFormWithoutCommas()">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        // Ambil elemen input
        var buyPriceInput = document.getElementById('buy_price');
        var sellPriceInput = document.getElementById('sell_price');
        var stockInput = document.getElementById('stock');

        document.getElementById('buy_price').addEventListener('input', function() {
            // Ambil nilai harga beli
            var buyPrice = parseFloat(this.value.replace(/[^\d\.]/g, ''));

            // Cek apakah nilai harga beli adalah angka valid
            if (!isNaN(buyPrice)) {
                // Hitung harga jual
                var sellPrice = buyPrice + (buyPrice * 0.3); // 30% dari harga beli

                // Isi nilai harga jual ke input sell_price
                document.getElementById('sell_price').value = sellPrice.toLocaleString();
            } else {
                // Jika input tidak valid, kosongkan nilai harga jual
                document.getElementById('sell_price').value = '';
            }
        });

        // Tambahkan event listener untuk memformat input dengan tanda koma
        buyPriceInput.addEventListener('input', function(event) {
            var value = parseFloat(this.value.replace(/[^\d\.]/g, ''));
            if (!isNaN(value)) {
                this.value = value.toLocaleString();
            } else {
                this.value = '';
            }
        });

        sellPriceInput.addEventListener('input', function(event) {
            var value = parseFloat(this.value.replace(/[^\d\.]/g, ''));
            if (!isNaN(value)) {
                this.value = value.toLocaleString();
            } else {
                this.value = '';
            }
        });

        stockInput.addEventListener('input', function(event) {
            var value = parseFloat(this.value.replace(/[^\d\.]/g, ''));
            if (!isNaN(value)) {
                this.value = value.toLocaleString();
            } else {
                this.value = '';
            }
        });

        function submitFormWithoutCommas() {
            // Hapus tanda koma dari nilai input
            buyPriceInput.value = buyPriceInput.value.replace(/,/g, '');
            sellPriceInput.value = sellPriceInput.value.replace(/,/g, '');
            stockInput.value = stockInput.value.replace(/,/g, '');
        }
    </script>
@endsection
