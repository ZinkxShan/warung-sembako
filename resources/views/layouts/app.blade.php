<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Sembako</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 3px solid #f59e0b;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: #f59e0b !important;
        }

        .nav-link {
            font-weight: 500;
            color: #374151 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #fef3c7;
            color: #d97706 !important;
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 130px);
        }

        footer {
            background-color: #ffffff;
            border-top: 2px solid #f59e0b;
            padding: 1rem 0;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('harga') }}">
                Warung
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('harga') ? 'active' : '' }}"
                           href="{{ route('harga') }}">
                            <i class="bi bi-tags"></i> Daftar Harga
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}"
                           href="{{ route('produk.index') }}">
                            <i class="bi bi-box-seam"></i> Kelola Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bon.index') || request()->routeIs('bon.*') ? 'active' : '' }}"
                           href="{{ route('bon.index') }}">
                            <i class="bi bi-receipt"></i> Bon Hutang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bon.riwayat') ? 'active' : '' }}"
                           href="{{ route('bon.riwayat') }}">
                            <i class="bi bi-clock-history"></i> Riwayat
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p class="mb-0">© {{ date('Y') }} Warung — Semua harga dapat berubah sewaktu-waktu</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>