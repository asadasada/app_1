<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '履歴書おきば') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>
    <script src="{{ secure_asset('js/custom.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @if(app('env') == 'production')
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/custom616.css') }}" rel="stylesheet">
    @else
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/custom616.css') }}" rel="stylesheet">
    @endif
</head>
<body>
    <div id="app">
        <!-- navはnavbar -->
        @component('layouts.navBar')
        @slot('link1')
        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        @endslot
        @slot('link2')
        <a class="nav-link" href="{{ route('register') }}">登録</a>
        @endslot
        @slot('link3')
        <a class="nav-link" href="{{ route('customers.home') }}">採用の方はこちら</a>
        @endslot

        @endcomponent
        <!-- sideBar -->
        @component('layouts.sideBar',["userss"=>$userss])
        <!-- 表示してる test -->
        @endcomponent
        <!-- 表示している test -->
        <!-- /sideBar -->
        <main class="py-3 main">
            @if($errors->any())
            hoge
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- これが親になる -->
            @yield('content')
        </main>
    </div>
</body>
</html>
