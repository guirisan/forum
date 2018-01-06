<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.App = {!! json_encode([
            'signedIn' => Auth::check(),
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ])!!}
    </script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { padding-bottom: 100px; }
        .level { display: flex; align-items: center; }
        .flex {flex: 1;}
        .mr-1 { margin-right: 1em; }
        .ml-a { margin-left: auto; }
        [v-cloak] { display: none; }
    </style>

    @yield('header')

</head>

<body style="padding-bottom: 200px">
    <div id="app">
        @include('layouts.nav')

        @yield('content')

        {{-- <flash message="Something"></flash> --}}
        <flash message="{{ session('flash') }}"></flash>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
