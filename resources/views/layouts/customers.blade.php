<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>人材発掘センター</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>
    <script src="{{ secure_asset('js/custom.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @if(app('env') == 'production')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom616.css') }}" rel="stylesheet">
    @else
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/custom616.css') }}" rel="stylesheet">
    @endif
</head>
<body>
    <div id="app">
        @component('layouts.navBar')
        @slot('link1')
        <a class="nav-link" href="{{ route('customers.login') }}">ログイン(customer)</a>
        @endslot
        @slot('link2')
        <a class="nav-link" href="{{ route('customers.register') }}">登録(customer)</a>
        @endslot
        @slot('link3')
        <a class="nav-link" href="{{ route('home') }}">ユーザの方はこちら</a>
        @endslot
        @endcomponent
        @component('layouts.sideBar')
        @endcomponent
        <main class="py-3 main">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @yield('content')
        </main>

    </div>
</body>
</html>