<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Bookmark;
use App\Models\Genre;
use App\Models\Booking;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class ShopController extends Controller
{
    public function index(Shop $shop) {

        $shops = Shop::with(['genre', 'area'])->get();
        $areas = Area::all();
        $genres = Genre::all();

        $user = Auth::user();
        $bookmark = [];

        if(Auth::check()) {
            // pluck：該当ユーザにブックマークされているお店のidを集めてくる
            $bookmark = Bookmark::where('user_id', $user->id)
            ->pluck('shop_id')->toArray();
        }

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
        $bookmark = [];

        if($user) {
            $bookmark = Bookmark::where('user_id', $user->id)
            ->pluck('shop_id')->toArray();
        }

        $selectedArea = $request->area_id;
        $selectedGenre = $request->genre_id;

        return view('index', compact('shops', 'areas', 'genres', 'selectedArea', 'selectedGenre', 'bookmark'));
    }

    //お店の詳細ページ
    public function detail($id)
    {
        $shop = Shop::with(['genre', 'area'])->find($id);

        //予約可能期間
        $today = Carbon::today()->toDateString();
        $maxDate = Carbon::today()->addDays(90)->toDateString();
        $minTime = Carbon::now()->addHours(1)->toTimeString();

        return view('detail', compact('shop', 'today', 'maxDate'));
    }

    //予約処理
    public function storeBooking(Request $request)
    {
        $user = Auth::user();

        if($user) {
            $booking = Booking::create([
                'shop_id' => $request->shop_id,
                'user_id'=> Auth::id(),
                'date' => $request->date,
                'time' => $request->time,
                'number' => $request->number,
            ]);
            return redirect('done');
        } else {
            return redirect()->with('message', '予約するにはログインしてください');
        }
    }

    public function destroyBooking(Request $request)
    {
        $booking = Booking::find($request->id);

        if($booking){
            $booking->delete();
        }

        return redirect('mypage');
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

    //予約完了ページ
    public function viewDone()
    {
        return view('done');
    }
}
