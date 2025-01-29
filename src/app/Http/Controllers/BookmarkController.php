<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {

        $user = Auth::user();
        $shop_id = $request->input('shop_id');

        if ($user) {
            $user_id = Auth::id();

            $isBookmarked = Bookmark::where('shop_id', $shop_id)
                ->where('user_id', $user_id)
                ->first();

            if (!$isBookmarked) {
                $shop = Shop::find($shop_id);
                Bookmark::createBookmark($user, $shop);
            }
        }

        return back();
    }

    public function destroy(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $bookmark = Bookmark::where('shop_id', $shop_id)
            ->where('user_id', $user_id);

        if ($bookmark) {
            $bookmark->delete();
        }

        return back();
    }
}
