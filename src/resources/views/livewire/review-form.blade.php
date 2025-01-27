<div class="review__right">
    <form method="POST" enctype="multipart/form-data" wire:submit.prevent="save">
        @csrf
        <div class="review__right__unit">
            <h2 class="review__right--title">体験を評価してください</h2>
            <div class="review__rating">
                <input class="review__rating--input" id="star5" name="rating" type="radio" value="5" wire:model="rating">
                <label class="review__rating--label" for="star5"><i class="fa-solid fa-star 2xl"></i></label>

                <input class="review__rating--input" id="star4" name="rating" type="radio" value="4" wire:model="rating">
                <label class="review__rating--label" for="star4"><i class="fa-solid fa-star 2xl"></i></label>

                <input class="review__rating--input" id="star3" name="rating" type="radio" value="3" wire:model="rating">
                <label class="review__rating--label" for="star3"><i class="fa-solid fa-star 2xl"></i></label>

                <input class="review__rating--input" id="star2" name="rating" type="radio" value="2" wire:model="rating">
                <label class="review__rating--label" for="star2"><i class="fa-solid fa-star 2xl"></i></label>

                <input class="review__rating--input" id="star1" name="rating" type="radio" value="1" wire:model="rating">
                <label class="review__rating--label" for="star1"><i class="fa-solid fa-star 2xl"></i></label>
            </div>
            @error('rating')
            <p class="review--error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="review__right__unit">
            <h2 class="review__right--title">口コミを投稿</h2>
            <textarea class="review__comment" name="comment" rows="8" placeholder="カジュアルな夜のお出かけにおすすめのスポット" wire:model="comment"></textarea>
            <span class="review__comment-counter">{{ $charsCount }}/400（最高文字数）</span>
            @if ($charsCount > 400)
            <p class="review--error-message">文字数は400文字以内でご入力ください。</p>
            @endif
        </div>
        <div class="review__right__unit">
            <h2 class="review__right--title">画像の追加</h2>
            <div class="review__image">
                @if($image)
                <div class="review__image--container">
                    <img src="{{ is_string($image) ? $image : $image->temporaryUrl() }}" class="review__image--preview">
                    <button wire:click="closePreviewImage()" type="button" class="review__image--close">削除</button>
                </div>
                @else
                <label for="image">
                    <div class="review__image__inner">
                        <p>クリックして写真を追加</p>
                        <span>またはドラッグ&amp;ドロップ</span>
                        <p>※ jpegまたはpng ファイルサイズ最大5MB</p>
                    </div>
                </label>
                <input type="file" name="image" id="image" wire:model="image" accept="image/*" hidden />
                @endif
            </div>
            @if ($errors->has('image'))
            @foreach($errors->get('image') as $message)
            <p class="review--error-message">
                {{ $message }}5MB以内のjpeg、png形式のファイルを使用してください。
            </p>
            @endforeach
            @endif
        </div>
    </form>
</div>