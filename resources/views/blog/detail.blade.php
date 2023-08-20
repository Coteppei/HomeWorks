{{-- コンテナの中身のみ --}}
{{-- 継承 --}}
@extends('layout')
@section('title', 'ブログ詳細')
@section('content')
<style>
   .center-image {
    display: block;
    margin: 0 auto;
    max-width: 100%;
}
</style>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>{{$blogs->title}}</h2>
        {{-- 日付を表示する --}}
        <p>質問者投稿日：{{$blogs->created_at}}</p>
        <br>
        <a href="#" data-toggle="modal" data-target="#imageModal">
            <div class="images">
                <img src="{{ asset('storage/' . $blogs->image_path) }}" alt="Image"  width="500px">
            </div>
        </a>
        <div style="overflow: auto; max-height: 300px;"> <!-- スクロール可能なコンテンツの領域 -->
            <br>
            <h4>詳細説明</h4>
            <p>{{$blogs->content}}</p>
        </div>
    </div>
</div>

<!-- 画像拡大用モーダル -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $blogs->image_path) }}" alt="Image" class="center-image" id="modalImage" width="1000px">
            </div>
        </div>
    </div>
</div>
<br>

<h3>回答・コメントを投稿する</h3>
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
        <br>
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
<br>
<br>
<h3>回答・コメントを確認する</h3>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @foreach ($replies as $reply)
            <hr>
            <p>回答者返答日：{{$reply->created_at}}</p>
            <p>{{$reply->content}}</p>
        @endforeach
        <hr>
        <br>
        <a class="btn btn-secondary" href="{{ route('blogs') }}">
            掲示板トップに戻る
        </a>
        <br>
        <br>
        <br>
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


