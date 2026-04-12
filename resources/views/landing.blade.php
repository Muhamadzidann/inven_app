<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inventaris - SMK Wikrama</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            background-color: #f5f6f8;
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            padding-top: 120px;
            padding-bottom: 60px;
        }

        .feature-card {
            border-radius: 12px;
            overflow: hidden;
            background: white;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-box {
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-dark-blue { background: #0d1b4c; }
        .bg-orange { background: #f4a300; }
        .bg-purple { background: #a9a6d8; }
        .bg-green { background: #66c2a5; }

        footer {
            font-size: 14px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.jpeg') }}" width="50">
        </a>

        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero text-center">
    <div class="container">
        <h1 class="fw-bold">
            Inventory Management of <br>
            <span>SMK Wikrama</span>
        </h1>

        <p class="text-secondary mt-3">
            Management of incoming and outgoing items at SMK Wikrama Bogor.
        </p>

        <img src="{{ asset('images/back.jpeg') }}"
             class="img-fluid mt-4"
             style="max-height:300px;">
    </div>
</section>

<!-- SYSTEM FLOW -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold">Our system flow</h2>
        <p class="text-muted mb-5">Our inventory system workflow</p>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="feature-card shadow-sm">
                    <div class="feature-box bg-dark-blue">
                        <img src="{{ asset('images/1.jpeg') }}" width="80">
                    </div>
                    <div class="p-3">
                        <p class="mb-0">Items Data</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card shadow-sm">
                    <div class="feature-box bg-orange">
                        <img src="{{ asset('images/3.jpeg') }}" width="80">
                    </div>
                    <div class="p-3">
                        <p class="mb-0">Management Technician</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card shadow-sm">
                    <div class="feature-box bg-purple">
                        <img src="{{ asset('images/2.jpeg') }}" width="80">
                    </div>
                    <div class="p-3">
                        <p class="mb-0">Managed Lending</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card shadow-sm">
                    <div class="feature-box bg-green">
                        <img src="{{ asset('images/4.jpeg') }}" width="80">
                    </div>
                    <div class="p-3">
                        <p class="mb-0">All Can Borrow</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-5 bg-white mt-5">
    <div class="container">
        <div class="row">

            <!-- LEFT -->
            <div class="col-md-4 mb-4">
                <img src="{{ asset('images/logo.jpeg') }}" width="60" class="mb-3">
                <p class="mb-1">smkwikrama@sch.id</p>
                <p>001-7876-2876</p>
            </div>

            <!-- MIDDLE -->
            <div class="col-md-4 text-md-end mb-4">
                <h6 class="fw-bold">Our Guidelines</h6>
                <ul class="list-unstyled text-muted">
                    <li>Terms</li>
                    <li class="text-danger">Privacy policy</li>
                    <li>Cookie Policy</li>
                    <li>Discover</li>
                </ul>
            </div>

            <!-- RIGHT -->
            <div class="col-md-4 text-md-end">
                <h6 class="fw-bold">Our address</h6>
                <p class="text-muted">
                    Jalan Wangun Tengah <br>
                    Sindangsari <br>
                    Jawa Barat
                </p>
            </div>

        </div>
    </div>
</footer>

<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-4">
                <h5 class="text-center mb-4" id="loginModalLabel">Login</h5>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if($errors->any() || session('open_login_modal'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('loginModal');
    if (el) bootstrap.Modal.getOrCreateInstance(el).show();
});
</script>
@endif
</body>
</html>