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
            <img src="{{ asset(Auth::user()->avatar) }}" width="200" class="img-circle" alt="">
            <label for="image" class="position-absolute bottom-0 end-0">
                <input type="file" class="form-control d-none" id="image" onchange="showConfirmation();" />
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

        <form action="{{ url('profile/update') }}" method="post" id="profile-form" class="row g-3 mt-2"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="image" id="image-input">
        </form>
    </div>
@endsection

@section('custom-js')
    <script>
        function showConfirmation() {
            // Menampilkan pesan konfirmasi
            if (confirm("Apakah Anda yakin ingin memilih file ini?")) {
                // Jika pengguna mengklik 'Ok', lanjutkan dengan submit form profile
                document.getElementById("profile-form").submit();
            } else {
                // Jika pengguna mengklik 'Cancel', kosongkan nilai input file
                document.getElementById("image").value = "";
            }
        }

        // Ketika pengguna memilih file, set nilai input file yang tersembunyi
        document.getElementById('image').addEventListener('change', function() {
            var fileInput = document.getElementById('image');
            var file = fileInput.files[0];
            // var fileName = file ? file.name : '';
            document.getElementById('image-input').value = file;
        });
    </script>
@endsection
