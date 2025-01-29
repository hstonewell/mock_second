<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            Booking::create([
                'shop_id' => $request->shop_id,
                'user_id' => Auth::id(),
                'date' => $request->date,
                'time' => $request->time,
                'number' => $request->number,
            ]);
            return redirect('done');
        } else {
            return redirect()->with('message', '予約するにはログインしてください');
        }
    }

    public function destroy(Request $request)
    {
        $booking = Booking::find($request->id);

        if ($booking) {
            $booking->delete();
        }

        return redirect('mypage');
    }

    //予約完了ページ
    public function viewDone()
    {
        return view('done');
    }
}
