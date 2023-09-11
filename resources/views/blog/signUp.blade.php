@extends('layout')
@section('title', 'アカウント作成')
@section('content')
<form method="POST" action="{{ route('registration') }}">
    @csrf
    <div class="login-container">
        <h2>アカウント作成</h2>
        <p class="mt-4 login_font_size" style="white-space: pre-wrap;">以下の項目に登録するユーザー名とパスワードを入れてください</p>
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
        <button type="button" class="btn btn-primary login-button" id="account_make_modal">
            確認
        </button>
        <a class="mb-5" href="{{route('login')}}">
            既にアカウントをお持ちの方はこちら
        </a>
    </div>

    <!-- サインアップデータ入力後モーダル表示 -->
    <div id="sign_up_Modal" class="modal">
        <div class="modal-content modal-attention">
            <div>
                <p class="mb-1">以下の登録内容でよろしいでしょうか</p>
                <div>
                    <p class="side-text">ユーザー名：</p>
                    <p class="mb-3 side-text" id="output_user_name"></p>
                </div>
                <div>
                    <p class="side-text">パスワード：</p>
                    <p class="mb-3 side-text" id="output_password"></p>
                </div>
            </div>
            <div class="col-md-13">
                <button type="submit" class="btn btn-primary btn-block mb-4">
                    登録
                </button>
            </div>
            <div class="col-md-13">
                <a href="#" class="btn btn-secondary btn-block" id="sign_up_closeModal">
                    キャンセル
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
