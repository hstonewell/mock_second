@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
<link rel="stylesheet" href="{{ asset('css/shops.css')}}">
@endsection

@section('search')
<div class="shop-search__form">
    <div class="shop-search__box">
        <form class="shop-search__unit" action="{{ route('search') }}" method="GET">
            @csrf
            <select name="sort" class="shop-search--select" onchange="this.form.submit(this.form)">
                <option value="random" {{ $sort == 'random' ? 'selected' : '' }}>ランダム表示</option>
                <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>評価の高い順</option>
                <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>評価の低い順</option>
            </select>
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
        </form>
    </div>
</div>
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
            <h4 class="shops__card--rating"><i class="fa-solid fa-star" style="color: #FFD43B;"></i>{{ number_format($shop->average_rating ?? 0, 1) }}({{ $shop->reviews->count() }})</h4>
            <div class="shops__card--tags">
                <a href="{{ route('search', ['area_id' => $shop->area->id])}}">&#035;{{ $shop->area->area_name }}</a>
                <a href="{{ route('search', ['genre_id' => $shop->genre->id])}}">&#035;{{ $shop->genre->genre_name }}</a>
            </div>
            <div class="shops__card--footer">
                <a href="{{ route('detail', ['shop_id'=>$shop->id]) }}" class="submit-button">詳しくみる</a>
                @hasanyrole('user')
                @if(in_array($shop->id, $bookmark))
                <form action="{{ route('bookmarks.destroy', $shop->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: red;"></i></button>
                </form>
                @else
                <form action="{{ route('bookmarks.show') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button type="submit" class="shops__card--bookmark"><i class="fa-solid fa-heart fa-2xl" style="color: #eee;"></i></button>
                </form>
                @endif
                @endhasanyrole
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection