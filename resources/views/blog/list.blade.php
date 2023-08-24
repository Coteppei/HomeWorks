{{-- コンテナの中身のみ --}}
{{-- 継承 --}}
@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>ブログ記事一覧</h2>
        @if (session('err_msg'))
            <p class="text-danger">
                {{session('err_msg')}}
            </p>
        @endif
        <table class="table table-striped">
            <tr>
                <th>記事番号</th>
                <th>学生カテゴリー</th>
                <th>教科目カテゴリー</th>
                <th>タイトル</th>
                <th>日付</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td>{{ $blog->school}}</td>
                <td>{{ $blog->subject }}</td>
                <td><a href="/blog/{{ $blog->id }}">{{ $blog->title }}</a></td>
                <td>{{ $blog->updated_at }}</td>
                <td><a href="{{ route('edit', ['id' => $blog->id]) }}" class="btn btn-primary">編集</a></td>

                <form method="POST" action="{{ route('delete', $blog->id) }}" onSubmit="return checkDelete()">
                @csrf
                <td><button type="submit" class="btn btn-primary" onclick=>削除</button></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<script>
    function checkDelete(){
    if(window.confirm('削除してよろしいですか？')){
        return true;
    } else {
        return false;
    }
    }
    </script>
@endsection


