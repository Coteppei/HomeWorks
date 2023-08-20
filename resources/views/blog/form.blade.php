@extends('layout')
@section('title', 'ブログ投稿')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>新規投稿フォーム</h2>
        {{-- enctypeは画像アップロード用の文言 --}}
        <form method="POST" action="{{ route('store') }}" onSubmit="return checkSubmit()" enctype="multipart/form-data">
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
            <div class="form-group">
                <label for="subject">
                    教科目カテゴリー
                </label>
                <br>
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
            <div class="mt-5">
                <a class="btn btn-secondary" href="{{ route('blogs') }}">
                    キャンセル
                </a>
                <button type="submit" class="btn btn-primary ">
                    投稿する
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function checkSubmit(){
if(window.confirm('送信してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>
@endsection
