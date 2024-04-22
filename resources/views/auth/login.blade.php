<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMS | Login</title>
    <link href="{{ asset('assets') }}/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-danger">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">
                                        <i class="fa-solid fa-bag-shopping text-danger"></i> SIMS Web App
                                    </h3>
                                </div>
                                <h3 class="text-center mt-3">Masuk atau buat akun untuk memulai</h3>
                                <div class="card-body p-4">
                                    @if (session('danger'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('danger') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{ url('/login') }}" method="post">
                                        @csrf
                                        <div class="input-group mb-4">
                                            <span class="input-group-text" id="email-addon">
                                                <i class="fa-solid fa-at"></i>
                                            </span>
                                            <input type="email" name="email" id="email"
                                                value="herdianafrody@gmail.com" class="form-control"
                                                placeholder="masukkan email anda" aria-label="Email"
                                                aria-describedby="email-addon" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="password-addon">
                                                <i class="fa-solid fa-lock"></i>
                                            </span>
                                            <input type="password" name="password" id="password" value="123456"
                                                class="form-control" placeholder="masukkan password andalam password"
                                                aria-label="Password" aria-describedby="password-addon" required>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-5 mb-0">
                                            <button type="submit" class="btn btn-danger w-100">Masuk</button>
                                            {{-- <a href="{{ url('/products') }}" class="btn btn-danger w-100">Masuk</a> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets') }}/js/scripts.js"></script>
</body>

</html>
