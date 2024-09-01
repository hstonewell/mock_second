@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}">
@endsection

@section('content')
<div class="thanks">
    <div class="thanks__item"><span class="thanks--logo">会員登録ありがとうございます</span></div>
    <div class="thanks__item">
        <form class="register" method="GET" action="/login">
            @csrf
            <input class="thanks--button" type="submit" value="ログインする">
        </form>
    </div>
</div>
@endsection