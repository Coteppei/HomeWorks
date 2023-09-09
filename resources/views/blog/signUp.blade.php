@extends('layout')
@section('title', 'アカウント作成')
@section('content')

<form method="POST" action="{{ route('registration') }}">
    @csrf
    <div class="login-container">
        <h2>アカウント作成</h2>
        <p class="mt-4">以下の項目に登録するユーザー名とパスワードを入れてください</p>
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
        <div id="error-message" class="error-message" style="display: none; color: red;">
            <h4>ユーザー名とパスワードを入力してください。</h4>
        </div>
        <input class="user_name" type="text" id="user_name" name="user_name" placeholder="ユーザー名">
        <input class="password" type="password" id="password" name="password" placeholder="パスワード">
        <button type="submit" class="btn btn-primary login-button">
            登録
        </button>
        <a class="mb-5" href="{{route('login')}}">
            既にアカウントをお持ちの方はこちら
        </a>
    </div>
</form>

{{-- <div class="login-container">
    <h2>アカウント作成</h2>
    <p style="margin-top: 30px;">以下の項目に登録するユーザー名とパスワードを入れてください</p>
    <div id="error-message" class="error-message" style="display: none; color: red;">
        <h4>ユーザー名とパスワードを入力してください。</h4>
    </div>
    <input class="user_name" type="text" id="user_name" placeholder="ユーザー名を入力してください">
    <input class="password" type="password" id="password" placeholder="パスワードを入力してください">
    <button type="button" class="btn btn-primary login-button" onclick="showConfirmation()">
        登録
    </button>
    <a href="">
        既にアカウントをお持ちの方はこちら
    </a>
</div>
{{-- モーダル表示 --}}
{{-- <form method="POST" action="{{ route('registration')}}">
    @csrf
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeConfirmation()">&times;</span>
            <p>以下の内容で登録します。ご確認ください。</p>
            <p>ユーザー名: <span id="confirmed-user_name" name="user_name"></span></p>
            <p>パスワード: <span id="confirmed-password" name="password"></span></p>
            <button type="submit" class="btn btn-primary">登録</button>
            <button type="button" class="btn btn-secondary" onclick="closeConfirmation()">キャンセル</button>
        </div>
    </div>
</form> --}}

{{-- <script>
    const userNameInput = document.getElementById('user_name');
    const passwordInput = document.getElementById('password');
    const confirmedUserName = document.getElementById('confirmed-user_name');
    const confirmedPassword = document.getElementById('confirmed-password');

    userNameInput.addEventListener('input', () => {
        confirmedUserName.textContent = userNameInput.value;
    });

    passwordInput.addEventListener('input', () => {
        confirmedPassword.textContent = passwordInput.value;
    });
</script> --}}
@endsection
