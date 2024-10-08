<div>
    <form action="/bookings" method="POST" class="booking-form">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
        <input type="date" name="date" class="booking-date" min="{{ $minDate }}" max="{{ $maxDate }}" wire:model="date" value="{{ old('date') }}">

        <select name="time" class="booking__time-select" wire:model="time">
            @foreach($timeSlots as $slot)
            <option value="{{ $slot['displayTime'] }}" @if($slot['isDisabled']) disabled @endif {{ old('displayTime') == $time ? 'selected' : '' }}>{{ $slot['displayTime'] }}</option>
            @endforeach
        </select>
        <input type="number" name="number" min="1" max="10" class="booking__number-select" wire:model="number" value="{{ old('number') }}">
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
        @if(session('message'))
        <div class="booking__box--message">{{ session('message') }}</div>
        @endif
        <div class="booking__box--footer">
            <button class="booking-submit" type="submit">予約する</button>
        </div>
    </form>
</div>