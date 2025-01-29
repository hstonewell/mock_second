<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Bookmark;
use App\Models\Genre;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $sort = $request->input('sort', 'random');

        $query = Shop::with(['genre', 'area', 'reviews'])
            ->AreaSearch($request->area_id)
            ->GenreSearch($request->genre_id)
            ->KeywordSearch($request->keyword);

        switch ($sort) {
            case 'desc':
                $shops = $query->withAvg('reviews', 'rating')
                ->orderByRaw('CASE WHEN reviews_avg_rating IS NULL THEN 0 ELSE 1 END DESC')
                ->orderByDesc('reviews_avg_rating')
                ->get();
                break;
            case 'asc':
                $shops = $query->withAvg('reviews', 'rating')
                ->orderByRaw('CASE WHEN reviews_avg_rating IS NULL THEN 0 ELSE 1 END DESC')
                ->orderBy('reviews_avg_rating')
                ->get();
                break;
            default:
                $shops = $query->inRandomOrder()->get();
                break;
        }

        $areas = Area::all();
        $genres = Genre::all();

        $user = Auth::user();
        $bookmark = [];

        if ($user) {
            $bookmark = Bookmark::where('user_id', $user->id)
                ->pluck('shop_id')->toArray();
        }

        $selectedArea = $request->area_id;
        $selectedGenre = $request->genre_id;

        return view('index', compact('shops', 'areas', 'genres', 'selectedArea', 'selectedGenre', 'bookmark', 'sort'));
    }
}
