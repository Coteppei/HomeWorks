<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">宿題掲示板</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link link-color" href="{{ route('blogs') }}">宿題一覧<span class="sr-only"></span></a>
            @if (session()->has('id'))
            <form id="createForm" action="{{ route('create') }}" method="POST">
                @csrf
                <a id="createLink" class="nav-item nav-link link-color" href="#">新規投稿</a>
            </form>
            @else
                <a class="nav-item nav-link link-color" href="#" id="showModal">新規投稿</a>
            @endif
            {{-- 重複ログイン対策 --}}
            @if (session()->get('id'))  {{-- ログイン時ログアウトを表示 --}}
                <a class="nav-item nav-link link-color" href="{{ route('logout') }}">ログアウト</a>
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
        <span class="close-button" id="closeModal">&times;</span>
        <div>
        <p class="mb-1">新規投稿するには</p>
        <p class="mb-1">アカウント作成もしくは</p>
        <p class="mb-3">ログインしてください。</p>
    </div>
        <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
        <a href="{{ route('signUp') }}" class="btn btn-primary mt-3">アカウント作成</a>
    </div>
</div>
