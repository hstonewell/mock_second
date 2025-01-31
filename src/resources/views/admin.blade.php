@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css')}}">
@endsection

@section('search')

@endsection

@section('content')
<div class="admin__wrapper">
    <div class="upload">
        <h1>店舗情報追加</h1>
        <div class="upload__inner">
            <form action="{{ route('csv.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                @csrf
                <div class="upload-form__input">
                    <input type="file" name="csvFile" id="csvFile" />
                    @error('file')
                    <div class="error" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>
                <button class="submit-button">インポート</button>
            </form>
            @if(session('import_errors'))
            <div class="upload-form__errors">
                <p class="upload-form__errors--alert">▼アップロードできませんでした。下記のエラーを確認してください。</p>
                <div class="upload-form__errors-list">
                    <hr>
                    @foreach(session('import_errors') as $error)
                    <ul class="upload-form__error">
                        <p class="error-title"><span class="line-number">◼️{{ $error['line'] }}行目：</span>{{ $error['row'] }}</p>
                        @if(isset($error['errors']))
                        <ul>
                            @foreach($error['errors'] as $field => $messages)
                            @foreach($messages as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                            @endforeach
                        </ul>
                        @endif
                    </ul>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        @if (session('success'))
        <p>{{ session('success') }}</p>
        @endif
    </div>
</div>
@endsection