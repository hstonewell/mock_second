<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

use App\Models\Shop;
use App\Models\Bookmark;

class ReviewController extends Controller
{
    public function review ($id)
    {
        $shop = Shop::with(['genre', 'area'])->find($id);
        $user = Auth::user();
        $bookmarked = [];

        if (Auth::check()) {
            $bookmarked = Bookmark::where('user_id', $user->id)
            ->where('shop_id', $id)
            ->exists();
        }

        return view('review', compact('shop', 'bookmarked'));
    }

    public function destroy ($review_id)
    {
        $review = Review::where('id', $review_id)->first();

        if ($review->user_id === Auth::id()) {
            $review->delete();
            return redirect()->route('detail', ['shop_id' => $review->shop_id]);
        }

        return redirect()->route('detail', ['shop_id' => $review->shop_id])->withErrors('destroy', '削除権限がありません。');
    }
}
