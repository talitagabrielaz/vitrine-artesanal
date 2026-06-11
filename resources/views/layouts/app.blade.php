<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Vitrine Artesanal') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        @font-face {
            font-family: 'SummerHearts';
            src: url('/fonts/SummerHearts.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #f7f2ec;
            color: #3d2b1f;
        }

        /* NAVBAR */
        .navbar {
            background-color: #cba396 !important;
            border-bottom: 2px solid #b8897a;
            padding: 12px 0;
        }

        .navbar-brand {
            font-family: 'SummerHearts', serif;
            font-size: 2rem;
            color: #fff !important;
            letter-spacing: 2px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
        }

        .nav-link {
            color: #fff !important;
            font-family: 'Lato', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 6px 14px !important;
            transition: all 0.2s;
            opacity: 0.9;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff !important;
            opacity: 1;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .navbar-toggler {
            border-color: rgba(255,255,255,0.6) !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        .dropdown-menu {
            background-color: #fff;
            border: 1px solid #ddd0c8;
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-top: 8px;
        }

        .dropdown-item {
            color: #3d2b1f;
            font-size: 0.85rem;
            font-family: 'Lato', sans-serif;
            letter-spacing: 0.5px;
            padding: 10px 18px;
        }

        .dropdown-item:hover {
            background-color: #f7f2ec;
            color: #cba396;
        }

        /* MAIN */
        main {
            min-height: calc(100vh - 80px);
            padding: 40px 0;
        }

        /* TÍTULOS */
        h1, h2, h3, h4, h5 {
            font-family: 'Cormorant Garamond', serif;
            color: #3d2b1f;
            font-weight: 600;
        }

        /* CARDS */
        .card {
            border: 1px solid #ddd0c8;
            border-radius: 6px;
            box-shadow: 0 2px 12px rgba(61,43,31,0.07);
            background: #ffffff;
        }

        .card-header {
            background-color: #f0e8e0 !important;
            border-bottom: 1px solid #ddd0c8;
            font-family: 'Cormorant Garamond', serif;
            color: #3d2b1f;
            font-size: 1.15rem;
            font-weight: 600;
            border-radius: 6px 6px 0 0 !important;
            padding: 14px 20px;
            letter-spacing: 0.5px;
        }

        /* BOTÕES */
        .btn-primary {
            background-color: #cba396 !important;
            border-color: #b8897a !important;
            border-radius: 5px;
            font-family: 'Lato', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 9px 22px;
            color: #fff !important;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #b8897a !important;
            border-color: #a5796b !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .btn-secondary {
            background-color: #f0e8e0 !important;
            border-color: #ddd0c8 !important;
            color: #3d2b1f !important;
            border-radius: 5px;
            font-family: 'Lato', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .btn-secondary:hover {
            background-color: #ddd0c8 !important;
            border-color: #cba396 !important;
        }

        .btn-danger {
            border-radius: 5px;
            font-family: 'Lato', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* TABELA */
        .table {
            font-size: 0.88rem;
        }

        .table thead th {
            background-color: #f0e8e0;
            color: #3d2b1f;
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            border-bottom: 2px solid #ddd0c8;
        }

        .table tbody tr:hover {
            background-color: #faf6f2;
        }

        /* FORMULÁRIOS */
        .form-control, .form-select {
            border: 1px solid #ddd0c8;
            border-radius: 5px;
            font-size: 0.9rem;
            padding: 10px 14px;
            background-color: #fff;
            color: #3d2b1f;
            font-family: 'Lato', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            border-color: #cba396;
            box-shadow: 0 0 0 0.2rem rgba(203,163,150,0.25);
        }

        .form-label {
            color: #5c3d2e;
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ALERTAS */
        .alert-success {
            background-color: #f0f5f0;
            border-color: #b5d5aa;
            border-left: 4px solid #6aab5e;
            color: #2d5a27;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #fdf0ec;
            border-color: #e8b5a8;
            border-left: 4px solid #c0392b;
            color: #7a2515;
            border-radius: 5px;
        }

        /* BADGE */
        .badge {
            border-radius: 4px;
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: 0.72rem;
            padding: 4px 10px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 24px;
            background-color: #f0e8e0;
            border-top: 2px solid #ddd0c8;
            color: #9a7060;
            font-family: 'Lato', sans-serif;
            font-size: 0.78rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-top: 60px;
        }

        footer strong {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-weight: 600;
            color: #3d2b1f;
            letter-spacing: 1px;
            text-transform: none;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Vitrine Artesanal
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}" href="{{ route('produtos.index') }}">Produtos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">Categorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('landing') }}" target="_blank">Ver site público</a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nome }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer>
            <strong>Vitrine Artesanal</strong> &mdash; feito com cuidado
        </footer>
    </div>
</body>
</html>