<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cute U Wear') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body style=" background-color: #F0D6E8;">
    <div id="app" >
        <nav style="background-color:#E3B5D5;" class="navbar navbar-expand-md navbar-light shadow-sm text-black">
            <div class="container">              
                <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="Cute U Wear" style="width: 50px;" class="img-fluid image-sm" src="https://media.discordapp.net/attachments/1149339884134338580/1237969792770641950/1712241910389.png?ex=663d94b6&is=663c4336&hm=6e85735855659c0a4e6b0918fcef7124dee6c4ad4f1107ddb4765293f2f0cdb2&=&format=webp&quality=lossless&width=593&height=593"  />
            </a>
                <button class="navbar-toggler" style="background-color: #F0D6E8;" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/articles/add') }}" style="color: #000000;" class="nav-link">+ New Product</a>
                            </li>
                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li  class="nav-item" >
                                    <a style="color: #000000;" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" style="color: #000000;" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div style=" background-color: #000000;"  class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a style="color: #FAA4BB; background-color: #000000;" class="dropdown-item " href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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

        <main class="py-4" style=" background-color: #F0D6E8;">
            @yield('content')
        </main>
    </div>
</body>

</html>
