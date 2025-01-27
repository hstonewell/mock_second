@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="review__wrapper">
    <div class="review__inner">
        <div class="review__left">
            <div class="review__left--message">
                <h1 class="review__left--message">今回のご利用はいかがでしたか？</h1>
            </div>
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
                        <a href="{{ route('detail', ['shop_id'=>$shop->id]) }}" class="submit-button">詳しくみる</a>
                        @if(Auth::check())
                        @if($bookmarked)
                        <form action="{{ route('bookmark.destroy', $shop->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                            <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: red;"></i></button>
                        </form>
                        @else
                        <form action="{{ route('bookmark.show') }}" method="POST">
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                            <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: #eee;"></i></button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @livewire('review-form', ['shop_id' => $shop->id])
    </div>
    <div class="review__footer">
        <button class="review__footer--button" onclick="Livewire.emit('triggerSave')">口コミを投稿</button>
    </div>
</div>
@endsection