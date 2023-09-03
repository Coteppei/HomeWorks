@extends('layout')
@section('title', 'ブログ編集')
@section('content')
<form method="POST" action="{{ route('exelogin') }}">
    @csrf
    <div class="login-container">
        <h2>ログイン</h2>
        {{-- 未入力および空白での入力時エラー出力 --}}
        @if($errors->has('user_name'))
            <p class="text-danger">{{ $errors->first('user_name') }}</p>
            <p class="text-danger">{{ $errors->first('password') }}</p>
        @endif
        {{-- ユーザー名かパスワードもしくはその両方が間違っていた場合エラー出力 --}}
        @if (session('err_msg'))
            <p class="text-danger">{{session('err_msg')}}</p>
            <p class="text-danger">{{session('err_msg_next')}}</p>
        @endif
        <input class="user_name" type="text" name="user_name" placeholder="ユーザー名を入力してください" >
        <input class="password" type="password" name="password" placeholder="パスワードを入力してください" >
        <button type="submit" class="btn btn-primary login-button" >
            ログイン
        </button>
        <a class="mb-5" href="{{route('signUp')}}">
            アカウントをお持ちでない、<br>
            ログインできない方はこちら
        </a>
    </div>
</form>
@endsection