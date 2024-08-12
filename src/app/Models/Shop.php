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
        return $this->hasMany(Area::class);
    }

    public function genre()
    {
        /* 店0以上:ジャンル1 */
        return $this->hasMany(Genre::class);
    }

    public function bookmark()
    {
        /* 店1:お気に入り0以上 */
        return $this->belongsTo(Bookmark::class);
    }

    public function booking()
    {
        /* 店1:予約0以上 */
        return $this->belongsTo(Booking::class);
    }
}
