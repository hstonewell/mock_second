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
        <div class="review__wrapper">
            <div class="review__header">
                @can('create', App\Models\Review::class)
                @if(!$myReview)
                <a href="{{ route('review.create', ['shop_id'=>$shop->id]) }}" class="review--post-link">口コミを投稿する</a>
                @endif
                @endcan
            </div>
            <div class="review__content">
                <h3 class="review__content--button">全ての口コミ情報</h3>
                @foreach($reviews as $review)
                <div class="review__content__unit">
                    <hr>
                    @error('destroy')
                    <p>{{ $message }}</p>
                    @enderror
                    <div class="review__content--links">
                        @can('update', $review)
                        <a href="{{ route('review.create', ['shop_id'=>$shop->id]) }}" class="review--post-link">口コミを編集</a>
                        @endcan
                        @can('delete', $review)
                        <form action="{{ route('review.destroy', ['review_id' => $review->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="review--post-link">口コミを削除</button>
                        </form>
                        @endcan
                    </div>
                    <div class="review__content--rating">
                        @for ($i = 0; $i < $review->rating; $i++ )
                            <i class="fa-solid fa-star fa-2x" style="color: #3560F6;"></i>
                            @endfor
                    </div>
                    <div class="review__content--comment">
                        <p>{{ $review->comment }}</p>
                    </div>
                    <img src="{{ $review->image }}" class="review__content--image" />
                </div>
                @endforeach
            </div>
            {{ $reviews->links() }}
        </div>
    </div>
    <div class="shop-detail__block--right">
        <div class="booking__box">
            <div class="booking__box__inner">
                <h2 class="booking__title">予約</h2>
                @livewire('confirm', ['shop' => $shop])
            </div>
        </div>
    </div>
</div>
@endsection