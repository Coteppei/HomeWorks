@extends('layout')
@section('title', 'ブログ詳細')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {{-- ログインユーザーが宿題を投稿しているもののみ編集と削除ボタンを表示 --}}
        @if (session('success_msg'))
                <p class="text-danger">
                    {{ session('success_msg') }}
                </p>
            @endif
        <div class="btn-group">
            @if (session('id') === $blogs->login_user_id)
                <form method="GET" action="{{ route('edit', [$blogs->id]) }}">
                    <button type="submit" class="btn btn-primary">この宿題を編集する</button>
                </form>
                <form method="POST" action="{{ route('delete', [$blogs->id]) }}" onSubmit="return checkDelete()">
                    @csrf
                    <button type="submit" class="btn btn-danger ml-5 mb-5 mr-5">この宿題を削除する</button>
                </form>
            @endif
        </div>
        {{-- タイトルから順に常時表示 --}}
        <p class="side-text gray mb-1">学生カテゴリー：</p>
        <p class="side-text gray mr-3">{{ $blogs->school }}</p>
        <p class="side-text gray">教科目カテゴリー：</p>
        <p class="side-text gray mr-3">{{ $blogs->subject }}</p>
        <br>
        <p class="side-text gray ">宿題投稿日：</p>
        <p class="side-text gray mr-3">{{ $blogs->created_at }}</p>
        <h2>{{$blogs->title}}</h2>
        {{-- 画像投稿がある時のみ画像を表示 --}}
        @if ($blogs->image_path !== null)
            <a href="#" data-toggle="modal" data-target="#imageModal">
                <div class="images">
                    <img src="{{ asset('storage/' . $blogs->image_path) }}" alt="Image"  width="100%">
                </div>
            </a>
        @endif
        <div style="overflow: auto; max-height: 300px;">
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
        <button type="submit" class="btn btn-primary mr-5" >
            投稿する
        </button>
    </div>
</form>
<h3 class="mt-5">回答・コメントを確認する</h3>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @foreach ($replies as $reply)
            @php
                $photo_id = $loop->iteration;
            @endphp
            <hr>
                <div>
                    <p class="small-text side-text">{{ $photo_id }}.</p>
                    <p class="small-text side-text">回答者返答日：</p>
                    <p class="small-text side-text">{{$reply->created_at}}</p>
                    <p>{{$reply->content}}</p>
                </div>
            {{-- 画像登録 --}}
            @if ($reply->image_path !== null)
                <a href="#" data-toggle="modal" data-target="#imageModal{{ $photo_id }}">
                    <div class="images">
                        <img src="{{ asset('storage/' . $reply->image_path) }}" alt="Image"  width="200px">
                    </div>
                </a>
            @endif
        @endforeach
        <hr>
        <div class="d-flex">
            @if (session()->has('user_search_flg'))
                <a class="btn btn-secondary mt-2 mb-5 mr-2" href="{{ route('userSearch') }}">
            @else
                <a class="btn btn-secondary mt-2 mb-5 mr-2" href="{{ route('blogs') }}">
            @endif
                掲示板トップに戻る
            </a>
            @if (session()->has('id') && session('id') === $blogs->login_user_id && $blogs->resolve_judgement === 0)
                <form method="POST" action={{ route('resolve') }} onSubmit="return checkResolve()">
                    @csrf
                    <input type="hidden" name="id" value="{{ $blogs->id }}">
                    <button type="submit" class="btn btn-Resolve ml-5 mt-2 mb-4">
                        🎊宿題が解決した🎉
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
<!-- 投稿画像を表示する -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $blogs->image_path) }}" alt="Image" class="center-image" id="modalImage1" width="1000px">
            </div>
        </div>
    </div>
</div>
<!-- 返信で添付された画像がある場合、その画像をモーダル表示 -->
@isset($reply)
    @foreach ($replies as $reply)
        @php
            $photo_id = $loop->iteration;
        @endphp
        <div class="modal fade" id="imageModal{{ $photo_id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel2">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $reply->image_path) }}" alt="Image" class="center-image" id="modalImage{{ $photo_id }}" width="1000px">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endisset
@endsection
