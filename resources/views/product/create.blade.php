@extends('layouts.master')

@section('title')
    SIMS | Produk
@endsection

@section('product-active')
    active
@endsection

@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/products') }}">Daftar Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Input Produk</li>
            </ol>
        </nav>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ url('/products/store') }}" class="row g-3" id="product-form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4">
                        <label for="category" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" name="category" id="category">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ old('category') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label for="name" class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Masukkan nama barang" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="buy_price" class="form-label fw-semibold">Harga Beli</label>
                        <input type="text" class="form-control" name="buy_price" id="buy_price"
                            placeholder="Masukkan harga beli" value="{{ old('buy_price') }}">
                        @error('buy_price')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="sell_price" class="form-label fw-semibold">Harga Jual</label>
                        <input type="text" class="form-control" name="sell_price" id="sell_price"
                            placeholder="Harga jual akan diisi otomatis" value="{{ old('sell_price') }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="stock" class="form-label fw-semibold">Stok Barang</label>
                        <input type="text" class="form-control" name="stock" id="stock"
                            placeholder="Masukkan jumlah stok barang" value="{{ old('stock') }}">
                        @error('stock')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="image" class="form-label fw-semibold">Gambar</label>
                        <div class="input-group mb-0">
                            <input type="file" class="form-control" name="image" id="image" />
                        </div>
                        @error('image')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 mt-5 d-flex justify-content-end">
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
