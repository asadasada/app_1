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
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @if(app('env') == 'production')
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom416.css') }}" rel="stylesheet">
@else
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom416.css') }}" rel="stylesheet">
@endif
</head>
<body>
    <div id="app">
        <!-- navはnavbar -->
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                        履歴書ひろば
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest('web')
                        @guest('customers')
                            <li><a class="nav-link" href="{{ route('login') }}">ログイン</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">登録</a></li>
                            <li><a class="nav-link" href="{{ route('customers.home') }}">採用の方はこちら</a></li>
                            @endguest
                        @else
                        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile',Auth::user()->name) }}">{{ Auth::user()->name }}のプロファイル</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        @auth('customers')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('customers')->user()->name }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('customers.profile',Auth::guard('customers')->user()->name) }}">{{ Auth::guard('customers')->user()->name }}のページ</a>
                                <a class="dropdown-item" href="{{ route('customers.logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <!-- csrf用form -->
                            <form id="logout-form" action="{{ route('customers.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endauth
                    </ul>
                </div>
            </div>
        </nav>
        @auth('web')
        <div id="test">
            履歴書一覧
            <ol>
                @foreach ($users as $user)
                <li><a href="{{ route('profile',$user->name) }}">{{ $user->name }}の履歴書</a></li>
                @endforeach
            </ol>
        </div>
        @endauth
                @auth('customers')
        <div id="test">
            履歴書一覧
            <ol>
                @foreach ($users as $user)
                <li><a href="{{ route('customers.u_profile',$user->name) }}">{{ $user->name }}の履歴書</a></li>
                @endforeach
            </ol>
        </div>
        @endauth
        @auth('web')
        <div id="test2">
            会社一覧
            <ol>
                @foreach ($customers as $customer)
                <li><a href="{{ route('c_profile',$customer->name) }}">{{ $customer->name }}の会社のページ</a></li>
                @endforeach

            </ol>
        </div>
        @endauth
                @auth('customers')
        <div id="test2">
            会社一覧
            <ol>
                @foreach ($customers as $customer)
                <li><a href="{{ route('customers.profile',$customer->name) }}">{{ $customer->name }}の会社のページ</a></li>
                @endforeach

            </ol>
        </div>
        @endauth
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
