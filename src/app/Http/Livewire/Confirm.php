<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Bookmark;
use App\Models\Genre;

use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class Confirm extends Component
{
    public $shop;
    public $date;
    public $time;
    public $number;
    public $timeCarbon;

    public function mount($shop)
    {
        //最短の予約時間は60分後（15分単位で切り上げ）
        $earliestTime = 60;
        $roundUp = 15;

        $roundedTime = Carbon::now()->addMinutes($earliestTime + $roundUp - Carbon::now()->minute % $roundUp);

        $this->shop = $shop;
        $this->date = $roundedTime->toDateString();
        $this->time = $roundedTime->format('H:i');
        $this->timeCarbon = $roundedTime->setSeconds(0)->setMicro(0);
        $this->number = 1;
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
        $minDate = Carbon::today()->toDateString();
        $maxDate = Carbon::now()->addMonth(3)->toDateString();

        $startTime =
            Carbon::createFromTime(12, 0);
        $endTime =
            Carbon::createFromTime(26, 0);
        $timeSlots = $this->generateTimeSlots($startTime, $endTime);

        $isToday = Carbon::parse($this->date)->isToday();

        return view('livewire.confirm', compact('minDate', 'maxDate', 'timeSlots', 'isToday'));
    }

    private function generateTimeSlots()
    {
        $startHour = 12;
        $endHour = 25;
        $timeSlots = [];

        for ($hour = $startHour; $hour <= $endHour; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 15) {
                // 24時を超えた場合の時間フォーマット
                if ($hour >= 24) {
                    $formattedHour = $hour - 24 + 24;
                    $time = sprintf('%02d:%02d', $formattedHour, $minute);
                    $carbonTime = Carbon::today()->setTime($hour - 24, $minute);
                } else {
                    $time = sprintf('%02d:%02d', $hour, $minute);
                    $carbonTime = Carbon::today()->setTime($hour, $minute)->setSeconds(0)->setMicro(0);
                }

                $isToday = Carbon::parse($this->date)->isToday();
                $asToday = $isToday && $carbonTime->hour < 27;

                $isDisabled = $asToday && $carbonTime->lt($this->timeCarbon);

                $timeSlots[] = [
                    'timeString' => $time,  // 表示用の時間
                    'isDisabled' => $isDisabled,
                ];
            }
        }
        return $timeSlots;
    }
}
