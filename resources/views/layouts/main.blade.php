<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="@yield('ngApp')">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hope') }} | @yield('page-title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-4.6.1/bootstrap.min.css') }}">
    <!-- FontAwesome -->
    <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select-1.13.14/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ng-table.min.css') }}" rel="stylesheet">
    <!-- AngularJS -->
    <script src="{{ asset('js/angular-1.8.2/angular.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.1.2/sweetalert.min.js') }}"></script>


</head>
<body ng-controller="@yield('ngController')">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('home') }}">Usuarios <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('perfiles') }}">Perfiles</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                Formularios
                </a>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ url('tipoformularios') }}">Tipos de Formularios</a>
                <a class="dropdown-item" href="{{ url('tipos-de-campos') }}">Tipo de Campos</a>
                <a class="dropdown-item" href="{{ url('campos-para-formularios') }}">Crear Formularios</a>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ url('tipoformularios') }}">Tipos de Formularios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('tipos-de-campos') }}">Tipo de Campos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('campos-para-formularios') }}">Crear Formularios</a>
            </li> -->
            </ul>
            <ul class="navbar-nav mx-auto">

            </ul>
            <ul class="navbar-nav pr-3">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('logout') }}"
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




    </nav>
    <main class="py-4">
        @yield('content')
    </main>

    <script src="{{ asset('js/jquery-3.5.1/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/bootstrap-4.6.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('js/dirPagination.js') }}"></script>
    <script src="{{ asset('js/ng-table.min.js') }}"></script>
    <!-- Angular File -->
    @yield('ngFile')
</body>
</html>
