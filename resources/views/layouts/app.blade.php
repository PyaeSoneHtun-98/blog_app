<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add favicon -->
    <link rel="icon" type="image/png" href="{{ asset('articles/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('articles/logo.png') }}">

    <title>{{ config('app.name', 'Cute U Wear') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            --bg-primary: #1F1D2B;        /* Dark blue-gray background */
            --bg-secondary: #252837;      /* Slightly lighter blue-gray */
            --card-bg: #2B2D3E;           /* Card background */
            --primary: #F08CB0;           /* Keep the pink */
            --accent: #FAA4BB;            /* Light pink */
            --text-light: #FFFFFF;        /* White text */
            --text-muted: #A0A0B3;        /* Muted blue-gray text */
            --border-color: #353748;      /* Border color */
            --hover-color: #323548;       /* Hover state */
        }

        body, #app, main {
            background-color: var(--bg-primary) !important;
            color: var(--text-light);
            font-family: system-ui, -apple-system, sans-serif;
        }

        .navbar {
            background-color: var(--bg-secondary) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand, .nav-link {
            color: var(--text-light) !important;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-primary:hover {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 0.8rem;
            margin-bottom: 1rem;
            height: 100%;  /* Make all cards same height */
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background-color: var(--hover-color);
        }

        .product-image {
            height: 180px;  /* Slightly smaller for mobile */
            overflow: hidden;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 0.8rem;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            height: auto;     /* Remove fixed height */
            max-height: 2.8rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .price-tag {
            padding: 0.3rem 0.8rem;
            font-size: 0.85rem;
        }

        .product-info {
            font-size: 0.75rem;
            line-height: 1.3;
            margin-top: auto;  /* Push info to bottom */
        }

        .icon-text {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        main {
            min-height: calc(100vh - 60px);
            margin-top: 66px; /* navbar height */
            padding-top: 15px;
        }

        .table {
            background-color: var(--card-bg);
            color: var(--text-light);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead {
            background-color: var(--primary);
            color: var(--bg-primary);
        }

        .text-muted {
            color: var(--text-muted) !important;
            opacity: 0.9;
        }

        /* Form controls */
        .form-control {
            background-color: #ffffff !important;
            border-color: var(--border-color);
            color: #2c3e50 !important;
        }

        .form-control:focus {
            background-color: #ffffff !important;
            border-color: var(--primary);
            color: #2c3e50 !important;
            box-shadow: 0 0 0 0.2rem rgba(240, 140, 176, 0.25);
        }

        /* Select control */
        .form-select {
            background-color: #ffffff !important;
            border-color: var(--border-color);
            color: #2c3e50 !important;
        }

        .form-select:focus {
            background-color: #ffffff !important;
            border-color: var(--primary);
            color: #2c3e50 !important;
            box-shadow: 0 0 0 0.2rem rgba(240, 140, 176, 0.25);
        }

        /* Pagination */
        .page-link {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--primary);
        }

        .page-link:hover {
            background-color: var(--hover-color);
            color: var(--accent);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--bg-primary);
        }

        .comment-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color) !important;
            transition: all 0.2s;
        }

        .comment-item:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Improved alert styling */
        .alert {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-light);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 0.5rem !important;
            }

            .badge.bg-primary {
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
            }

            .btn-sm {
                padding: 0.2rem 0.5rem;
                font-size: 0.75rem;
            }

            .card-title {
                font-size: 0.85rem !important;
                margin-bottom: 0.5rem !important;
            }

            .small {
                font-size: 0.7rem !important;
            }

            .fa-sm {
                font-size: 0.7rem !important;
            }

            /* Tighter grid spacing */
            .g-2 {
                --bs-gutter-x: 0.5rem;
                --bs-gutter-y: 0.5rem;
            }

            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }

        /* Extra small devices */
        @media (max-width: 576px) {
            .card-img-top {
                height: 130px !important;
            }
        }

        .badge.bg-primary {
            background-color: var(--primary) !important;
            color: var(--bg-primary) !important;
            font-size: 0.95rem;
            padding: 0.5rem 0.8rem;
            font-weight: 600;
        }

        /* Fix card title color */
        .card-title {
            color: var(--text-light) !important;
        }

        /* Improve card body spacing */
        .card-body {
            padding: 1rem;
        }

        /* Update image styles */
        .card-img-top {
            aspect-ratio: 1 / 1;  /* Force square ratio */
            object-fit: cover;
            width: 100%;
        }

        /* Container padding adjustments */
        @media (min-width: 1200px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
                max-width: 1140px;
            }
        }

        @media (min-width: 992px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        @media (max-width: 991px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</head>

<body>
    <div id="app" >
        <nav style="background-color:#2C3E50;" class="navbar navbar-expand-md navbar-dark shadow-sm fixed-top">
            <div class="container">              
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img alt="Cute U Wear" style="width: 50px;" class="img-fluid image-sm" src="{{ asset('articles/logo.png') }}"  />
                </a>
                <button class="navbar-toggler" style="background-color: #FDE6F6;" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <!-- Empty now that we've removed categories -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            @role('admin')
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                </li>
                            @endrole
                            <li class="nav-item dropdown">
                                <a href="#" 
                                   class="nav-link dropdown-toggle text-white" 
                                   id="navbarDropdown" 
                                   role="button" 
                                   data-bs-toggle="dropdown" 
                                   aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" 
                                     style="background-color: #2C3E50;">
                                    <a class="dropdown-item" 
                                       style="color: #ffffff;" 
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="" style="margin-top: 56px;">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
            crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle dropdown clicks
            document.querySelectorAll('.dropdown-toggle').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    var dropdown = new bootstrap.Dropdown(element);
                    dropdown.toggle();
                });
            });
        });
    </script>
</body>

</html>
