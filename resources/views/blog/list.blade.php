{{-- コンテナの中身のみ --}}
{{-- 継承 --}}
@extends('layout')
@section('content')
@php
    $subjects = config('arrays.subjects');
    $schools = config('arrays.schools');
@endphp
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>宿題一覧</h2>
        @if (session('err_msg'))
            <p class="text-danger">
                {{ session('err_msg') }}
            </p>
        @endif
        <form action="{{ route('search') }}" method="GET">
            @csrf
            <div class="form-group">
                <h4>カテゴリー検索</h4>
                <label for="school">
                    学生カテゴリー
                </label>
                <br>
                <select name="search">
                    @foreach ($schools as $school)
                        <option
                        id="{{ $school }}"
                        value="{{ $school }}"
                        >{{ $school }}</option>
                    @endforeach
                </select>
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
                <select name="search_sub">
                    @foreach ($subjects as $subject)
                        <option
                            id="{{ $subject }}"
                            value="{{ $subject }}"
                        >{{ $subject }}</option>
                    @endforeach
                </select>
                @if ($errors->has('subject'))
                    <div class="text-danger">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
        <form action="{{ route('search') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="search">キーワード検索</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="キーワードを入力してください">
                    <button type="submit" class="btn btn-primary">検索</button>
            </div>
        </form>
        <form action="{{ route('blogs') }}" method="POST">
            <button type="submit" class="btn btn-primary mb-4">検索のリセット</button>
        </form>
        <table class="table table-striped">
            <tr>
                <th>学生カテゴリー</th>
                <th>教科目カテゴリー</th>
                <th>タイトル</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($blogs as $blog)
                <tr onclick="location.href='{{ route('show', ['id' => $blog->id]) }}'">
                    <td>{{ $blog->school }}</td>
                    <td>{{ $blog->subject }}</td>
                    <td><a href="{{ route('show', ['id' => $blog->id]) }}">{{ $blog->title }}</a></td>
                    <td><a href="{{ route('edit', ['id' => $blog->id]) }}" class="btn btn-primary">編集</a></td>
                    <td>
                        <form method="POST" action="{{ route('delete', ['id' => $blog->id]) }}" onSubmit="return checkDelete()">
                            @csrf
                            <button type="submit" class="btn btn-primary">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </form>
        </table>
    </div>
</div>
@endsection


