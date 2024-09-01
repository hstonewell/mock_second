<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Bookmark extends Model
{
    use HasFactory;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;

    public static function createBookmark($user, $shop)
    {
        $bookmark = new Bookmark();
        $bookmark->user_id = $user->id;
        $bookmark->shop_id = $shop->id;
        $bookmark->save();

        return $bookmark;
    }

}
