@extends('layout')
@section('title', 'ブログ編集')
@section('content')
<div class="login-container">
    <h2>ログイン</h2>
    <input class="user_name" type="text" placeholder="ユーザー名を入力してください" >
    <input class="password" type="password" placeholder="パスワードを入力してください" >
    <button type="submit" class="btn btn-primary login-button" >
        ログイン
    </button>
    <a href="">
        アカウントをお持ちでない、<br>
        ログインできない方はこちら
    </a>
</div>
@endsection
