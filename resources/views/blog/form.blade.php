@extends('layout')
@section('title', 'ブログ投稿')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>新規投稿フォーム</h2>
        {{-- enctypeは画像アップロード用の文言 --}}
{{-- 改修予定：ユーザーでログインできているときはformで遷移できるようにする。できていないときはログイン画面へ遷移する仕組みを作る。 --}}
        <form method="POST" action="{{ route('store') }}" onSubmit="return formCheckSubmit()" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="school">
                    学生カテゴリー
                </label>
                <br>
                @php
                $schools = ['小学生', '中学生', '高校生', '大学生'];
                @endphp
                @foreach ($schools as $school)
                    <input
                        id="{{ $school }}"
                        name="school"
                        value="{{ $school }}"
                        type="radio"
                        {{ old('school') === $school ? 'checked' : '' }}
                    >{{ $school }}
                @endforeach
                @if ($errors->has('school'))
                    <div class="text-danger">
                        {{ $errors->first('school') }}
                    </div>
                @endif
            </div>
            <div class="form-group mb-1">
                <label for="subject">
                    教科目カテゴリー
                </label>
            </div>
            <div class="form-group">
                @php
                $subjects = ['国語', '算数', '数学', '理科', '社会', '英語', '自由研究', '論文', 'その他'];
                @endphp
                <select name="subject">
                @foreach ($subjects as $subject)
                <option
                    id="{{ $subject }}"
                    value="{{ $subject }}"
                >{{ $subject }}
                </option>
                @endforeach
                </select>
                @if ($errors->has('subject'))
                    <div class="text-danger">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="title">
                    タイトル
                </label>
                <input
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    type="text"
                >
                @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
            {{-- 画像登録の構文 --}}
            <div class="form-group">
                <label for="image">画像登録</label>
                <input
                    type="file"
                    class="form-control-file"
                    name="image"
                    id="image"
                >
            </div>
            <div class="form-group">
                <label for="content">
                    本文
                </label>
                <textarea
                    id="content"
                    name="content"
                    class="form-control"
                    rows="4"
                >{{ old('content') }}</textarea>
                @if ($errors->has('content'))
                    <div class="text-danger">
                        {{ $errors->first('content') }}
                    </div>
                @endif
            </div>
            <div class="mt-5 mb-5">
                <a class="btn btn-secondary" href="{{ route('blogs') }}">
                    キャンセル
                </a>
                <button type="submit" class="btn btn-primary">投稿する</button>
                {{-- 改修予定-モーダルで新規投稿か確認する --}}
                {{-- <button type="submit" class="btn btn-primary" button id="showModal">投稿する</button> --}}
                {{-- 20230902メモ：モーダル出さないでログイン画面へ遷移でもよいかも。そこに注意文言を出すようにして！ --}}
                <div id="myModal" class="modal">
                    <div class="login-modal-content">
                        <p>問題を投稿する場合はアカウントを新規登録するかログインしてください。</p>
                        <br>
                            <tr>
                                <th>アカウント登録をしていない方</th>
                            </tr>
                            <tr>
                                <td><button class="modal-button btn btn-primary" onclick="window.location.href='register.html'">新規登録</button></td>
                            </tr>
                            <tr>
                                <th>アカウント登録済みの方</th>
                            </tr>
                            <tr>
                                <td><button class="modal-button btn btn-primary" onclick="window.location.href='login.html'">ログイン</button></td>
                            </tr>
                            <br>
                            <button class="modal-button" onclick="closeModal()">戻る</button>
                    </div>
                </div>
                <div id="overlay" class="overlay"></div>
            </div>
        </form>
    </div>
</div>

{{-- モーダル用のjs一旦コメントアウト --}}

{{-- <script>
document.getElementById("showModal").addEventListener("click", function() {
    const modal = document.getElementById("myModal");
    modal.style.display = "block";
    const overlay = document.getElementById("overlay");
    modal.style.display = "block";
    overlay.style.display = "block";
});
function closeModal() {
    const modal = document.getElementById("myModal");
    modal.style.display = "none";
    const overlay = document.getElementById("overlay");
    modal.style.display = "none";
    overlay.style.display = "none";
}
</script> --}}
@endsection
