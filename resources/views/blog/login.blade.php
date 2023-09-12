@extends('layout')
@section('title', 'ブログ編集')
@section('content')
<form method="POST" action="{{ route('exelogin') }}">
    @csrf
    <div class="login-container">
        <h2>ログイン</h2>
        <p class="mt-4 login_font_size">以下の項目に登録したユーザー名とパスワードを入れてください</p>
        {{-- 未入力および空白での入力時エラー出力 --}}
        @if($errors->has('user_name'))
            <p class="text-danger">{{ $errors->first('user_name') }}</p>
        @endif
        @if ($errors->has('password'))
            <p class="text-danger">{{ $errors->first('password') }}</p>
        @endif
        {{-- ユーザー名かパスワードもしくはその両方が間違っていた場合エラー出力 --}}
        @if (session('err_msg'))
            <p class="text-danger">{{session('err_msg')}}</p>
            <p class="text-danger">{{session('err_msg_next')}}</p>
        @endif
        <input class="user_name" type="text" name="user_name" placeholder="ユーザー名" >
        <input class="password" type="password" name="password" placeholder="パスワード" >
        <button type="submit" class="btn btn-primary login-button" >
            ログイン
        </button>
        <a class="mb-5" href="{{route('signUp')}}">
            <p class="mb-1">アカウントをお持ちでない、</p>
            <p>ログインできない方はこちら</p>
        </a>
    </div>
</form>
@endsection
