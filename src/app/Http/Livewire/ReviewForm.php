<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Review;

class ReviewForm extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $shop_id;
    public $rating;
    public $comment = '';
    public $image;
    public $charsCount = 0;

    protected $listeners = ['triggerSave' => 'save'];

    // 初期設定
    public function mount($shop_id)
    {
        $this->shop_id = $shop_id;
        $review = Review::where('user_id', Auth::id())
            ->where('shop_id', $this->shop_id)
            ->first();

        if ($review) {
            $this->authorize('update', $review);

            $this->rating = $review->rating;
            $this->comment = $review->comment;
            $this->image = $review->image;
        }
    }

    // バリデーション
    protected function validateReview()
    {
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:400',
        ];

        if ($this->image && !is_string($this->image)) {
            $rules['image'] = 'nullable|image|max:5020|mimes:jpg,jpeg,png';
        }

        return $this->validate($rules);
    }

    // 画面表示
    public function render()
    {
        return view('livewire.review-form');
    }

    // 文字数カウント
    public function updatedComment($value)
    {
        $this->charsCount = mb_strlen($value);
    }

    // レビュー画像のプレビュー表示
    public function updatedImage()
    {
        $this->validateReview('image');
    }

    public function closePreviewImage()
    {
        $this->image = null;
    }

    // 保存処理
    public function save()
    {
        $validated = $this->validateReview();

        $reviewImageUrl = null;

        if ($this->image && !is_string($this->image)) {
            $imagePath = $this->image->store('review-images', 'public');
            $reviewImageUrl = Storage::url($imagePath);
        } elseif (is_string($this->image)) {
            $reviewImageUrl = $this->image;
        }

        $data = array_merge($validated, [
            'user_id' => Auth::id(),
            'shop_id' => $this->shop_id,
            'rating' => $this->rating,
            'comment' => $this->comment ?? null,
            'image' => $reviewImageUrl ?? null,
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'shop_id' => $this->shop_id],
            $data
        );

        return redirect()->route('detail', ['shop_id' => $this->shop_id]);
    }
}
