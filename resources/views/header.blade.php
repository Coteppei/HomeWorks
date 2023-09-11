<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">宿題掲示板</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link link-color" href="{{ route('blogs') }}">宿題一覧<span class="sr-only"></span></a>
            @if (session()->has('id'))
                <a class="nav-item nav-link link-color" href="{{ route('create') }}">新規宿題投稿</a>
                @if (session()->has('user_search_flg'))
                    <a class="nav-item nav-link link-color" href="{{ route('allSearch') }}">全ての宿題を表示</a>
                @else
                    <a class="nav-item nav-link link-color" href="{{ route('userSearch') }}">自分の宿題を表示</a>
                @endif
            @else
                <a class="nav-item nav-link link-color" href="#" id="showModal">新規宿題投稿</a>
            @endif
            {{-- ログイン判定 --}}
            @if (session()->get('id'))  {{-- ログイン時ログアウトを表示 --}}
                <a class="nav-item nav-link link-color" href="#" id="logoutModal">ログアウト</a>
            @else                       {{-- 未ログインの時はアカウント作成とログインを表示 --}}
                <a class="nav-item nav-link link-color" href="{{ route('signUp') }}">アカウント作成</a>
                <a class="nav-item nav-link link-color" href="{{ route('login') }}">ログイン</a>
            @endif
        </div>
    </div>
</nav>
<div class="text-center">
    @if (session()->get('user_name') === 'ユーザー未登録')

        <p class="mt-3 text-danger">
    @else
        <p class="mt-3">
    @endif
    {{ session()->get('user_name')}}
    </p>
</div>

<!-- 未ログイン時注意モーダル表示 -->
<div id="myModal" class="modal">
    <div class="modal-content modal-attention">
        {{-- <span class="close-button" id="closeModal">&times;</span> --}}
        <div>
        <p class="mb-1">新規宿題投稿するには</p>
        <p class="mb-1">アカウント作成もしくは</p>
        <p class="mb-3">ログインしてください。</p>
    </div>
        <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
        <a href="{{ route('signUp') }}" class="btn btn-primary mt-4">アカウント作成</a>
        <a href="#" class="btn btn-secondary mt-4" id="closeModal">キャンセル</a>
    </div>
</div>

<!-- ログアウト時注意モーダル表示 -->
<div id="submitModal" class="modal">
    <div class="modal-content modal-attention">
        <div>
        <p class="mb-1">ログアウトします</p>
        <p class="mb-1">よろしければログアウト実行</p>
        <p class="mb-3">ボタンを押してください。</p>
    </div>
        <a class="btn btn-primary mt-3" href="{{ route('logout') }}">ログアウトする</a>
        <a href="#" class="btn btn-secondary mt-4" id="logout_closeModal">キャンセル</a>
    </div>
</div>
