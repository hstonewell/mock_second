<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function area()
    {
        /* 店0以上:エリア1 */
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        /* 店0以上:ジャンル1 */
        return $this->belongsTo(Genre::class);
    }

    public function bookmark()
    {
        /* 店1:お気に入り0以上 */
        return $this->hasMany(Bookmark::class);
    }

    public function booking()
    {
        /* 店1:予約0以上 */
        return $this->hasMany(Booking::class, 'shop_id');
    }

    /* 検索 */
    public function scopeAreaSearch($query, $area_id)
    {
        if (!empty($area_id)) {
            $query->where('area_id', $area_id);
        }
    }
    public function scopeGenreSearch($query, $genre_id)
    {
        if (!empty($genre_id)) {
            $query->where('genre_id', $genre_id);
        }
    }
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('shop_name', 'like', '%' . $keyword . '%');
        }
    }
}
