@extends('layouts.master')

@section('title')
    SIMS | Produk
@endsection

@section('product-active')
    active
@endsection

@section('content')
    <div class="container-fluid px-4">
        <div class="position-relative" style="display: inline-block;">
            <img src="{{ Auth::user()->avatar }}" width="200" class="img-circle" alt="">
            <label for="image" class="position-absolute bottom-0 end-0">
                <form action="{{ url('profile/update') }}" id="avatar-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control d-none" name="image" id="image"
                        onchange="showConfirmation();" />
                </form>
                <i class="fas fa-pencil-alt rounded-circle bg-white p-2"
                    style="border: 1px solid black; width: 24px; height: 18px;"></i>
            </label>
        </div>
        <h2 class="my-3">{{ Auth::user()->name }}</h2>

        <form class="row g-3 mt-2">
            @csrf
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Kandidat</label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Posisi Kandidat</label>
                <input type="text" class="form-control" value="Web Programmer" readonly>
            </div>
        </form>
    </div>
@endsection

@section('custom-js')
    <script>
        function showConfirmation() {
            // Menampilkan pesan konfirmasi
            if (confirm("Apakah Anda yakin ingin memilih file ini?")) {
                // Jika pengguna mengklik 'Ok', lanjutkan dengan submit form profile
                document.getElementById("avatar-form").submit();
            }
        }
    </script>
@endsection
