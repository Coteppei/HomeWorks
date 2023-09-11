{{-- コンテナの中身のみ --}}
{{-- 継承 --}}
@extends('layout')
@section('content')
@php
    $subjects = config('arrays.subjects');
    $schools = config('arrays.schools');
@endphp
<div class="row">
    <div class="col-md-12 col-md-offset-2">
        @if (session('err_msg'))
            <p class="text-danger">
                {{ session('err_msg') }}
            </p>
        @endif
        <form action="{{ route('search') }}" method="GET">
            <div class="form-group mb-5">
                <h4>カテゴリー検索</h4>
                <table class="category-search">
                    <tr>
                        <th>学生カテゴリー</th>
                        <th>教科目カテゴリー</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            <select name="search">
                                @foreach ($schools as $school)
                                    <option
                                    id="{{ $school }}"
                                    value="{{ $school }}"
                                    >{{ $school }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="search_sub">
                                @foreach ($subjects as $subject)
                                    <option
                                        id="{{ $subject }}"
                                        value="{{ $subject }}"
                                    >{{ $subject }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-sm btn-primary">検索</button>
                        </td>
                    </tr>
                </table>
                @if ($errors->has('school'))
                    <div class="text-danger">
                        {{ $errors->first('school') }}
                    </div>
                @endif
            </div>
            <div class="form-group mb-1">
            </div>
            <div class="form-group">
                @if ($errors->has('subject'))
                    <div class="text-danger">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
            </div>
        </form>
        <h4>キーワード検索</h4>
        <div class="form-group">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" class="form-control mb-4" id="search" name="search" placeholder="キーワードを入力してください">
                <button type="submit" class="btn btn-primary float-right">検索</button>
            </form>
        </div>
        @if (session()->has('user_search_flg'))
            <form action="{{ route('userSearch') }}" method="GET">
        @else
            <form action="{{ route('blogs') }}" method="GET">
        @endif
            <button type="submit" class="btn btn-danger mt-5 mb-5">検索のリセット</button>
        </form>

        <h1 class="homewormb-5 text-center">宿題一覧</h1>
        @if(session('user_search_flg'))
            <div class="text-center text-danger">
                <b>自分の宿題のみ表示</b>
            </div>
        @endif
        @isset($keyword)
            <div class="text-center">
                <p class="side-text">検索ワード：</p>
                <b><p class="side-text ">{{ $keyword }}</p>
            </div>
        @endisset
        @foreach ($blogs as $blog)
        <hr color="#808080">
            <div class="click-range" onclick="location.href='{{ route('show', ['id' => $blog->id]) }}'">
                <p class="small-text side-text mb-1">学生カテゴリー：</p>
                <p class="small-text side-text mr-3">{{ $blog->school }}</p>
                <p class="small-text side-text">教科目カテゴリー：</p>
                <p class="small-text side-text mr-3">{{ $blog->subject }}</p>
                <b>
                    <p class="main-text">{{ $blog->title }}</p>
                </b>
                <div>
                    <p class="small-text side-text mb-1">投稿日：</p>
                    <p class="small-text side-text mb-1">{{ $blog->created_at }}</p>
                </div>
            </div>
        @endforeach
        <hr color="#808080">
    </div>
</div>

{{-- ページネーション表示 検索の有無で条件分岐 --}}
<div class="mb-5">
    @isset($keyword)
        {{ $blogs->appends(['search' => $keyword])->links() }}
    @else
        {{ $blogs->links() }}
    @endisset
</div>
<p id="scrollButton" class="scroll-button" ><a href="#"><img class="scroll-image" src="{{asset('upScroll.png')}}" alt=""></a></p>

@endsection
