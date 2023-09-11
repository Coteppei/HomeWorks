@extends('layout')
@section('title', 'ブログ編集')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {{-- 外部ユーザー対策 --}}
        @if (session('id') === $blogs->login_user_id)
            <h2>編集フォーム</h2>
            <form method="POST" action="{{ route('update') }}" onSubmit="return editCheckSubmit()" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{ $blogs->id }}">
                <div class="form-group">
                    <label for="title">
                        タイトル
                    </label>
                    <input
                        id="title"
                        name="title"
                        class="form-control"
                        value="{{ $blogs->title }}"
                        type="text"
                    >
                    @if ($errors->has('title'))
                        <div class="text-danger">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>
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
                    >{{ $blogs->content }}</textarea>
                    @if ($errors->has('content'))
                        <div class="text-danger">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                </div>
                <div class="mt-5 mb-5">
                    @if (session('previousUrl'))
                        <a class="btn btn-secondary" href="{{ session('previousUrl') }}">
                    @else
                        <a class="btn btn-secondary" href="{{ route('blogs') }}">
                    @endif
                            キャンセル
                        </a>
                    <button type="submit" class="btn btn-primary">
                        更新する
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
