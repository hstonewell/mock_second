<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Bookmark;
use App\Models\Genre;

use Carbon\Carbon;

class Confirm extends Component
{
    public $shop;
    public $date;
    public $time;
    public $number;
    public $timeCarbon;
    public $timeSlots = [];

    public function mount($shop)
    {
        //最短の予約時間は60分後（15分単位で切り上げ）
        $now = Carbon::now();
        $earliestTime = 60;
        $roundUp = 15;

        $roundedTime = $now->copy()->addMinutes($earliestTime + $roundUp - $now->minute % $roundUp);

        $this->shop = $shop;

        if ($roundedTime->hour < 2) {
            // 午前0時〜2時の場合、前日の日付として扱う
            $yesterday = $roundedTime->copy()->subDay(1);
            $this->date = $yesterday->toDateString();
            $this->time = sprintf('%02d:%02d', $roundedTime->hour + 24, $roundedTime->minute);
            $this->timeCarbon = $roundedTime->copy()->setSeconds(0)->setMicro(0);
        } else {
            // 通常の処理
            $this->date = $roundedTime->toDateString();
            $this->time = $roundedTime->format('H:i');
            $this->timeCarbon = $roundedTime->copy()->setSeconds(0)->setMicro(0);
        }

        $this->number = 1;
        $this->timeSlots = $this->generateTimeSlots();
    }

    public function updatedDate($value)
    {
        $this->date = $value;

        // 日付が変更されたらタイムスロットを再生成
        $this->timeSlots = $this->generateTimeSlots();
    }

    public function updatedTime($value)
    {
        $this->time = $value;
    }

    public function updatedNumber($value)
    {
        $this->number = $value;
    }

    public function render()
    {
        $now = Carbon::now();

        if ($now->hour < 1) {
            $minDate = $now->copy()->subDay()->toDateString();
        } else {
            $minDate = $now->copy()->toDateString();
        }
        $maxDate = $now->addMonth(3)->toDateString();

        $timeSlots = $this->generateTimeSlots();

        return view('livewire.confirm', compact('minDate', 'maxDate', 'timeSlots'));
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
}
