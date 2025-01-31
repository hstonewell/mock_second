<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Bookmark;
use App\Models\Genre;
use App\Models\Booking;
use App\Models\Review;

use Carbon\Carbon;

class ShopController extends Controller
{
    public function index(Request $request) {

        $sort = $request->input('sort', 'random');

        $query = Shop::with(['genre', 'area', 'reviews']);
        $shops = $query->inRandomOrder()->get();

        $areas = Area::all();
        $genres = Genre::all();

        $user = Auth::user();
        $bookmark = [];

        if(Auth::check()) {
            // pluck：該当ユーザにブックマークされているお店のidを集めてくる
            $bookmark = Bookmark::where('user_id', $user->id)
            ->pluck('shop_id')->toArray();
        }

        return view('index', compact('shops', 'areas', 'genres', 'bookmark', 'sort'));
    }

    //お店の詳細ページ
    public function detail($id)
    {
        $shop = Shop::with(['genre', 'area'])->find($id);

        $myReview = Auth::check()
        ? Review::where('user_id', Auth::id())->where('shop_id', $id)->first()
        : null;

        // 自分のレビューを除外した一覧
        $reviews = Review::where('shop_id', $shop->id)
        ->when($myReview, function ($query) {
            return $query->where('user_id', '!=', Auth::id());
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $lastBooking = Booking::lastBooking($shop->id, Auth::id())->first();

        $canPostReview = false;
        if ($lastBooking) {
            $possibleTime = Carbon::parse($lastBooking->date)->setTimeFromTimeString($lastBooking->time);
            $canPostReview = $possibleTime <= Carbon::now();
        }

        // 予約フォームの予約可能期間
        $today = Carbon::today()->toDateString();
        $maxDate = Carbon::today()->addDays(90)->toDateString();
        $minTime = Carbon::now()->addHours(1)->toTimeString();

        return view('detail', compact('shop', 'reviews', 'myReview', 'today', 'maxDate','lastBooking', 'canPostReview'));
    }

    //マイページ
    public function viewMyPage()
    {
        $user = Auth::user();
        $now = Carbon::now();

        $userBookmarks = Bookmark::where('user_id', $user->id)
        ->with('shop')
        ->get()
        ->pluck('shop');

        $userBookings = Booking::where('user_id', $user->id)
        ->with('shop')
        ->where('date', '>=', Carbon::today())
        ->get();

        return view('auth.mypage', compact('userBookmarks', 'userBookings'));
    }

}
