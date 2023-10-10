<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>宿題掲示板 ホームズワークス</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}?v={{ uniqid() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ uniqid() }}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}?v={{ uniqid() }}">
    <script src="{{asset('/js/app.js')}}?v={{ uniqid() }}"></script>
    <script src="{{asset('/js/main.js')}}?v={{ uniqid() }}"></script>
    <link rel="icon" href="{{asset('homework_girl.ico')}}">
</head>
<body>
    <header>
        @include('header')
    </header>
    <div class="container">
        @yield('content')
    </div>
    <footer class="footer bg-dark  fixed-bottom">
        @include('footer')
    </footer>
</body>
</html>
