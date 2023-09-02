{{-- コンテナの中身のみ --}}
{{-- 継承 --}}
@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>宿題一覧</h2>
        @if (session('err_msg'))
            <p class="text-danger">
                {{session('err_msg')}}
            </p>
        @endif
        <table class="table table-striped">
            <tr>
                <th>学生カテゴリー</th>
                <th>教科目カテゴリー</th>
                <th>タイトル</th>
                <th>日付</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($blogs as $blog)
                <tr onclick="location.href='{{ route('show', ['id' => $blog->id]) }}'">
                    <td>{{ $blog->school }}</td>
                    <td>{{ $blog->subject }}</td>
                    <td><a href="{{ route('show', ['id' => $blog->id]) }}">{{ $blog->title }}</a></td>
                    <td>{{ $blog->updated_at }}</td>
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


