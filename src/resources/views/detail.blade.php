@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('search')

@endsection

@section('content')
<div class="shopd-detail__wrapper">
    <div class="shop-detail__block">
        <div class="shop-detail__title">
            <a href="{{ url()->previous() }}" class="shop-detail--back">&lt;</a>
            <h2 class="shop-name">{{ $shop->shop_name }}</h2>
        </div>
        <img src="{{ $shop->image }}" alt="{{ $shop->shop_name }}">
        <div class="shop-tags">
            <p>&#035;{{ $shop->area->area_name }}</p>
            <p>&#035;{{ $shop->genre->genre_name }}</p>
        </div>
        <div class="shop-detail__description">
            {{ $shop->detail }}
        </div>
    </div>
    <div class="shop-detail__block">
        <div class="booking__box">
            <h2 class="booking__title">予約</h2>
            <div class="booking__box--main">
                @livewire('confirm', ['shop' => $shop])
            </div>
            <div class="booking__box--footer">
                <button class="booking-submit" type="submit">予約する</button>
            </div>
        </div>
    </div>
</div>


@endsection