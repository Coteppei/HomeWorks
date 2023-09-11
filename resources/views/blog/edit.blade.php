@extends('layout')
@section('title', 'ブログ編集')
@section('content')
@php
    $subjects = config('arrays.subjects');
    $schools = config('arrays.schools');
@endphp
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {{-- 外部ユーザー対策 --}}
        @if (session('id') === $blogs->login_user_id)
            <h2>編集フォーム</h2>
            <form method="POST" action="{{ route('update') }}" onSubmit="return editCheckSubmit()" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{ $blogs->id }}">
                <div class="form-group">
                    <label for="school">
                        学生カテゴリー
                    </label>
                    <br>
                    @foreach ($schools as $school)
                        <input
                            id="{{ $school }}"
                            name="school"
                            value="{{ $school }}"
                            type="radio"
                            {{ $blogs->school === $school ? 'checked' : '' }}
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
                    <select name="subject">
                    @foreach ($subjects as $subject)
                    <option
                        id="{{ $subject }}"
                        value="{{ $subject }}"
                        {{ $blogs->subject === $subject ? 'selected' : ''  }}
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
