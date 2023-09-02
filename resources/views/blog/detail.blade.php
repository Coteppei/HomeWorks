@extends('layout')
@section('title', 'ブログ詳細')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>{{$blogs->title}}</h2>
        {{-- 日付を表示する --}}
        <p>質問者投稿日：{{$blogs->created_at}}</p>
        <a href="#" data-toggle="modal" data-target="#imageModal">
            <div class="images">
                <img src="{{ asset('storage/' . $blogs->image_path) }}" alt="Image"  width="500px">
            </div>
        </a>
        <div style="overflow: auto; max-height: 300px;"> <!-- スクロール可能なコンテンツの領域 -->
            <h4 class="mt-4">詳細説明</h4>
            <p>{{$blogs->content}}</p>
        </div>
    </div>
</div>


<h3 class="mt-3 mb-3">回答・コメントを投稿する</h3>
<form method="POST" action="{{ route('reply',['foreign_id' => $blogs->id]) }}" onSubmit="return checkSubmit()" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
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
        <label for="image">画像登録</label>
        <input
            type="file"
            class="form-control-file"
            name="image"
            id="image"
        >
    <div class="mt-5">
        <a class="btn btn-secondary" href="{{ route('blogs') }}">
            掲示板トップに戻る
        </a>
        <button type="submit" class="btn btn-primary" >
            投稿する
        </button>
    </div>
</form>
<h3 class="mt-5">回答・コメントを確認する</h3>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @foreach ($replies as $reply)
            <hr>
            <p>回答者返答日：{{$reply->created_at}}</p>
            <p>{{$reply->content}}</p>
            {{-- 画像登録 --}}
            <a href="#" data-toggle="modal" data-target="#imageModal">
                <div class="images">
                    <img src="{{ asset('storage/' . $reply->image_path) }}" alt="Image"  width="200px">
                </div>
            </a>
        @endforeach
        <hr>
        <a class="btn btn-secondary mt-2 mb-5" href="{{ route('blogs') }}">
            掲示板トップに戻る
        </a>
    </div>
</div>
<!-- 画像拡大用モーダル -->
{{-- スマホ対応は今後実施予定 --}}

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $blogs->image_path) }}" alt="Image" class="center-image" id="modalImage" width="1000px">
            </div>
        </div>
    </div>
</div>
@endsection
