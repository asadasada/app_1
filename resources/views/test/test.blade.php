<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <!-- styleタグの埋め込みはapp.jsで打ち消し Test用なのでコメント化 -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
           <div id="hoge">Test_fst_page</div>
           @isset($hoge)
           @isset($piyo)
           <div>{{ $hoge }} and {{ $piyo }}</div>
           {{ hash("md5",3) }}
           @endisset
           @endisset
           <div><a href="{{ route('peke',['adada','dedede']) }}">adada</a></div>
           <style type="text/css" media="screen">
               #hoge{
                color:green;
                font-size: 30px;
               }
           </style>
        @yield('hoge1')
        <div>Component_top</div>
        @component('test.test3')
        Piyopiyo
        @endcomponent
        <div>end</div>
    </div>
</body>
</html>