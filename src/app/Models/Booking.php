<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'shop_id',
        'user_id',
        'date',
        'time',
        'number'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLastBooking($query, $shop_id, $user_id)
    {
        $query->where('user_id', $user_id)
            ->where('shop_id', $shop_id)
            ->orderBy('date', 'desc');
    }
}
