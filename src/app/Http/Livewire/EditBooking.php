<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Booking;

use Carbon\Carbon;

class EditBooking extends Component
{
    public $showEditBooking = false;
    public $showEdited = false;

    public $booking_id;
    public $shop;
    public $date;
    public $time;
    public $number;
    public $timeCarbon;
    public $timeSlots = [];

    public function mount($booking_id)
    {
        $this->booking_id = $booking_id;
        $this->loadBooking();
        $this->timeSlots = $this->generateTimeSlots();
    }

    private function loadBooking()
    {
        $booking = Booking::with('shop')->find($this->booking_id);
        $this->shop = $booking->shop;
        $this->date = $booking->date;

        $now = Carbon::now();
        $earliestTime = 60;
        $roundUp = 15;
        $roundedTime = $now->copy()->addMinutes($earliestTime + $roundUp - $now->minute % $roundUp);

        if ($roundedTime->hour < 2) {
            $this->time = sprintf('%02d:%02d', $roundedTime->hour + 24, $roundedTime->minute);
            $this->timeCarbon = $roundedTime->copy()->subDay()->setTime($roundedTime->hour, $roundedTime->minute)->setSeconds(0)->setMicro(0);
        } else {
            $this->time = $roundedTime->format('H:i');
            $this->timeCarbon = $roundedTime->copy()->setSeconds(0)->setMicro(0);
        }

        $this->number = $booking->number;
    }

    public function save()
    {
        $booking = Booking::find($this->booking_id);
        $booking->update([
            'date' => $this->date,
            'time' => $this->time,
            'number' => $this->number,
        ]);

        $this->openEdited();
    }

    public function openEdited()
    {
        $this->showEditBooking = false;
        $this->showEdited = true;
    }

    public function closeEdited()
    {
        $this->showEdited = false;
        return redirect('/mypage');
    }

    private function generateTimeSlots()
    {
        $now = Carbon::now();

        //予約可能時間は12-26時
        $startHour = 12;
        $endHour = 26;
        $timeSlots = [];

        // 0〜2時の場合、前日分のタイムスロットを表示
        if ($now->hour < 2) {
            $day = $now->copy()->subDay();  // 前日のスロットを表示
        } else {
            $day = $now->copy();  // 当日のスロットを表示
        }

        for ($hour = $startHour; $hour <= $endHour; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 15) {

                if ($hour < 24) {
                    $displayTime = sprintf('%02d:%02d', $hour, $minute);
                    $carbonTime = $day->copy()->setTime($hour, $minute)->setSeconds(0)->setMicro(0);
                }
                // 24時以降の時間帯
                else {
                    $displayTime = sprintf('%02d:%02d', $hour - 24 + 24, $minute);
                    $carbonTime = $day->copy()->addDay()->setTime($hour - 24, $minute)->setSeconds(0)->setMicro(0);
                }

                // 無効化の判定
                if (Carbon::parse($this->date)->toDateString() == $day->toDateString()) {
                    $isDisabled = $carbonTime->lt($this->timeCarbon);
                } else {
                    $isDisabled = false;
                }

                $timeSlots[] = [
                    'displayTime' => $displayTime,  // 表示用の時間
                    'isDisabled' => $isDisabled,   // 無効化フラグ
                ];
            }
        }
        return $timeSlots;
    }

    public function openEditBooking()
    {
        $this->showEditBooking = true;
    }
    public function closeEditBooking()
    {
        $this->showEditBooking = false;
    }
    public function updatedTime($value)
    {
        $this->time = $value;
    }
    public function updatedDate($value)
    {
        $this->date = $value;
        // 日付が変更されたらタイムスロットを再生成
        $this->timeSlots = $this->generateTimeSlots();
    }

    public function render()
    {
        $now = Carbon::now();

        if ($now->hour < 1) {
            $minDate = Carbon::yesterday()->toDateString();
        } else {
            $minDate = Carbon::today()->toDateString();
        }
        $maxDate = $now->addMonth(3)->toDateString();

        $timeSlots = $this->generateTimeSlots();

        return view('livewire.edit-booking', compact('minDate', 'maxDate', 'timeSlots'));
    }

}
