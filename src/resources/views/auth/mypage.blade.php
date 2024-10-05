@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/mypage.css')}}">
@endsection

@section('content')
<div class="mypage__wrapper">
    <div class="mypage-wrapper__header">
        <div class="mypage-title__left">
            <h3 class="mypage__title">予約状況</h3>
        </div>
        <div class="mypage-title__right">
            <h1 class="mypage__name">{{ Auth::user()->name }}さん</h1>
            <h3 class="mypage__title">お気に入り店舗</h3>
        </div>
    </div>

    <div class="mypage-wrapper__main">

        <div class="mypage__inner--booking">
            @foreach($userBookings as $booking)
            <div class="booking__card">
                <div class="booking__card--header">
                    <i class="fa-solid fa-clock fa-xl" style="color: #ffffff;"></i>
                    <p>{{ sprintf('%04d', $loop->iteration) }}</p>
                    <form action="{{ route('destroyBooking') }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" value="{{ $booking['id'] }}">
                        <button type="submit" class="booking__card--submit"><i class="fa-regular fa-circle-xmark fa-xl" style="color: #ffffff;"></i></button>
                    </form>
                </div>
                <table class="booking__card--table">
                    <tr>
                        <th>Shop</th>
                        <td>{{ $booking->shop->shop_name }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $booking->date }}</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>{{ substr($booking->time, 0, 5 ) }}</td>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <td>{{ $booking->number }}</td>
                    </tr>
                </table>
            </div>
            @endforeach
        </div>

        <div class="mypage__inner--bookmark">
            <div class="bookmark__cards">
                @foreach($userBookmarks as $shop)
                <div class="shops__card">
                    <div class="shops__card--img">
                        <img src="{{ $shop->image }}" name="image">
                    </div>
                    <div class="shops__card--unit">
                        <h3 class="shops__card--title" name="shop_name">{{ $shop->shop_name }}</h3>
                        <div class="shops__card--tags">
                            <a href="{{ route('search', ['area_id' => $shop->area->id])}}">&#035;{{ $shop->area->area_name }}</a>
                            <a href="{{ route('search', ['genre_id' => $shop->genre->id])}}">&#035;{{ $shop->genre->genre_name }}</a>
                        </div>
                        <div class="shops__card--footer">
                            <a href="{{ route('detail', ['shop_id'=>$shop->id]) }}" class="shops__card--more">詳しくみる</a>
                            <form action="{{ route('destroyBookmark', $shop->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: red;"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection