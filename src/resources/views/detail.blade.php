@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('search')

@endsection

@section('content')
<div class="shop-detail__wrapper">
    <div class="shop-detail__block--left">
        <div class="shop-detail__title">
            <a href="/" class="shop-detail--back">&lt;</a>
            <h2 class="shop-name">{{ $shop->shop_name }}</h2>
        </div>
        <img src="{{ $shop->image }}" alt="{{ $shop->shop_name }}">
        <div class="shop-tags">
            <a href="{{ route('search', ['area_id' => $shop->area->id])}}">&#035;{{ $shop->area->area_name }}</a>
            <a href="{{ route('search', ['genre_id' => $shop->genre->id])}}">&#035;{{ $shop->genre->genre_name }}</a>
        </div>
        <div class="shop-detail__description">
            {{ $shop->detail }}
        </div>
    </div>
    <div class="shop-detail__block--right">
        <div class="booking__box">
            <h2 class="booking__title">予約</h2>
            <div class="booking__box--main">
                @livewire('confirm', ['shop' => $shop])
            </div>
        </div>
    </div>
</div>


@endsection