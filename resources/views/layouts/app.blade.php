<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{--Część head pliku to kontener z metadanymi, czyli informacjami dotyczącymi dokumentu HTML, które nie są wyświetlane na stronie.--}}
<head>
    {{--    Znacznik meta używany jest do określenia informacji o danych, czyli metadanych.--}}
    {{--    Są one używane przez przeglądarki internwtowe i informują o sposobie wyświetlania treści.--}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--Element title definuje tytył dokumentu, który zostaje wyświetlony na pasku tytułu przeglądarki--}}
    <title>{{ config('app.name', 'Projekt pracy magisterskiej') }}</title>

    <!-- Scripts -->
    {{--    Element zwracający się do zewnętrznego pliku skryptów JS--}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{--Znacznik link używany jest do łączenia  zewnętrznych arkuszy stylów.--}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--Dołączenie zewnętrznego arkusza stylów style.css--}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

{{--Tag body definiuje ciało dokumentu, czyli zawiera całą zawartość dokumentu HTML--}}
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Projekt pracy magisterskiej') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    {{--Rozpoczęcie tworzenia górnego menu--}}
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Authentication Links -->
                        {{--Menu dla niezalogowanego użytkownika:--}}
                        {{--logowanie przkekierowujące do strony głównej--}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Logowanie</a>
                            </li>

                        {{--Menu, jeśli użytkownik jest zalogowany: imię użytkownika i rozwijalne menu--}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ auth()->user()->name }} <span class="caret"></span>
                                </a>

                                {{--Spis rozwijanego menu--}}
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                        Twoje dane
                                    </a>

                                    <a class="dropdown-item" href="{{ route('ewidencja.praca.create') }}">
                                        Ewidencja pracy
                                    </a>

                                    {{--Jeśli zalogowany uzytkownik posiada rolę proacownika pordukcji bądź admina, zostanie mu wyświetlona pozycja Ewidencji elementów--}}
                                    @if(auth()->user()->hasAnyRoles(['pracownik produkcji', 'admin']))

                                        <a class="dropdown-item" href="{{ route('ewidencja.elementy.index') }}">
                                            Ewidencja elementów
                                        </a>

                                    @endif

                                    {{--Pozycje menu dla użytkownika typu admin--}}
                                    @if(auth()->user()->hasRole('admin'))
                                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                            Zarządzanie pracownikami
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.users.create') }}">
                                            Utwórz konto pracownika
                                        </a>
                                    @endif

                                    {{--Pozycje menu dla użytkownika typu technolog lub admin--}}
                                    @if(auth()->user()->hasAnyRoles(['technolog', 'admin']))
                                        <a class="dropdown-item" href="{{ route('product.index') }}">
                                            Elementy
                                        </a>
                                        <a class="dropdown-item" href="{{ route('operation.index') }}">
                                            Operacje
                                        </a>
                                        <a class="dropdown-item" href="{{ route('product-operations.create') }}">
                                            Powiąż operacje z elementami
                                        </a>
                                        <a class="dropdown-item" href="{{ route('product-operations.index') }}">
                                            Zarządzaj powiązanymi operacjami
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Wyloguj
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @include('partials.alerts')
                @yield('content')
            </div>
        </main>
    </div>
    @yield('custom_blade_js')
</body>
</html>
