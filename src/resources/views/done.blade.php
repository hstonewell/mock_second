@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}">
@endsection

@section('content')
<div class="thanks">
    <div class="thanks__item"><span class="thanks--logo">ご予約ありがとうございます</span></div>
    <div class="thanks__item">
        <a href="{{ url()->previous() }}" class="thanks--button">戻る</a>
    </div>
</div>
@endsection