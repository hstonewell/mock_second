<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Bookmark;
use App\Models\Genre;

class ShopController extends Controller
{
    public function index(Shop $shop) {

        $user = Auth::user();
        $shops = Shop::with(['genre', 'area'])->get();
        $areas = Area::all();
        $genres = Genre::all();

        // pluck：該当ユーザにブックマークされているお店のidを集めてくる
        $bookmark = Bookmark::where('user_id', $user->id)
        ->pluck('shop_id')->toArray();

        return view('index', compact('shops', 'areas', 'genres', 'bookmark'));
    }

    //お気に入り機能
    public function storeBookmark(Request $request) {

        $user = Auth::user();
        $shop_id = $request->input('shop_id');

        if($user) {
            $user_id = Auth::id();

            $isBookmarked = Bookmark::where('shop_id', $shop_id)
            ->where('user_id', $user_id)
            ->first();

            if(!$isBookmarked) {
                $shop = Shop::find($shop_id);
                Bookmark::createBookmark($user, $shop);
            }
        }

        return redirect('/');
    }

    public function destroyBookmark(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $bookmark = Bookmark::where('shop_id', $shop_id)
        ->where('user_id', $user_id);

        if($bookmark) {
            $bookmark->delete();
        }

        return back();
    }

    //検索機能
    public function search(Request $request)
    {
        $shops = Shop::with(['genre', 'area'])
            ->AreaSearch($request->area_id)
            ->GenreSearch($request->genre_id)
            ->KeywordSearch($request->keyword)
            ->get();
        $areas = Area::all();
        $genres = Genre::all();

        $user = Auth::user();

        if($user) {
            $bookmark = Bookmark::where('user_id', $user->id)
            ->pluck('shop_id')->toArray();
        }

        $selectedArea = $request->area_id;
        $selectedGenre = $request->genre_id;

        return view('index', compact('shops', 'areas', 'genres', 'selectedArea', 'selectedGenre', 'bookmark'));
    }

    //マイページ
    public function viewMyPage()
    {
        $user = Auth::user();

        $userBookmarks = Bookmark::where('user_id', $user->id)
        ->with('shop')
        ->get()
        ->pluck('shop');

        return view('mypage', compact('userBookmarks'));
    }
}
