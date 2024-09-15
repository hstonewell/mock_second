<div>
    <form class="booking-form">
        @csrf
        <input type="date" class="booking-date" min="{{ $minDate }}" max="{{ $maxDate }}" wire:model="date">

        <select name="booking-time" class="booking-select" wire:model="time">
            @foreach($timeSlots as $slot)
            <option value="{{ $slot }}" @if($slot->isPast() && $slot->lt($this->time)) disabled @endif>{{ $slot }}</option>
            @endforeach
        </select>
        <input type="number" min="1" max="10" class="booking-select" wire:model="number">
    </form>

    <div class="layout"></div>

    <table class="booking-confirm__box">
        <tr>
            <th>Shop</th>
            <td>{{ $shop->shop_name }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $date }}</td>
        </tr>
        <tr>
            <th>Time</th>
            <td>{{ $time }}</td>
        </tr>
        <tr>
            <th>Number</th>
            <td>{{ $number }}</td>
        </tr>
    </table>
</div>