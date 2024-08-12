<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    public function shop()
    {
        return $this->hasMany(Shop::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
