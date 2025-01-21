@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css')}}">
@endsection

@section('content')
<div class="verify">
    <h2 class="verify__item--title">メールアドレスをご確認ください</h2>
    <div class="verify__item">
        <p>Reseをご利用いただくにはメール認証が必要です。</p>
        <p>もし確認用メールが送信されていない場合は、下記をクリックしてください。</p>
    </div>
    <form action="{{ route('verification.send') }}" method="POST" class="verify__item">
        @csrf
        <button type="submit" class="verify__item--button">確認メールを再送信する</button>
        </form>
    @if (session('status') == 'verification-link-sent')
    <div class="verify__item">
        <p class=" verify__item--message">ご登録いただいたメールアドレスに確認用のリンクをお送りしました。</p>
    </div>
    @endif
</div>
@endsection