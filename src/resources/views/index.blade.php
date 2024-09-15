@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('search')
<form class="shop-search__form" action="{{ route('search') }}" method="GET">
    @csrf
    <div class="shop-search__box">
        <select class="shop-search--select" name="area_id" onchange="submit(this.form)">
            <option value="">All area</option>
            @foreach ($areas as $area)
            <option value="{{ $area['id'] }}" @if(isset($selectedArea) && $selectedArea==$area->id) selected @endif>{{ $area->area_name }}</option>
            @endforeach
        </select>
        <select class="shop-search--select" name="genre_id" onchange="submit(this.form)">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
            <option value="{{ $genre['id'] }}" @if(isset($selectedGenre) && $selectedGenre==$genre->id) selected @endif>{{ $genre->genre_name }}</option>
            @endforeach
        </select>
        <button class="shop-search--icon"><i class="fa-solid fa-magnifying-glass" style="color: #000;"></i></button>
        <input class="shop-search--input" type="text" name="keyword" placeholder="Search..." value="{{ old('keyword', request('keyword')) }}">
    </div>
</form>

@endsection

@section('content')
<div class="shops__wrapper">
    @foreach($shops as $shop)
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
                @if(Auth::check())
                @if(in_array($shop->id, $bookmark))
                <form action="{{ route('destroyBookmark', $shop->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: red;"></i></button>
                </form>
                @else
                <form action="{{ route('storeBookmark') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: #eee;"></i></button>
                </form>
                @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection