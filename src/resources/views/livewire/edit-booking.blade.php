<div>
    <!-- 編集ボタン -->
    <button wire:click="openEditBooking()" type="button" class="booking__card--submit">
        <i class="fa-regular fa-pen-to-square fa-xl" style="color: #ffffff;"></i>
    </button>

    <!-- モーダルの表示 -->
    @if($showEditBooking)
    <div class="modal-overlay" wire:click.self="closeEditBooking">
        <div class="modal-content">
            <h2 class="booking__title">予約変更</h2>
            <form wire:submit.prevent="save" class="booking-form">
                @method('PATCH')
                @csrf
                <input type="date" id="date" name="date" wire:model="date" class="form-control" min="{{ $minDate }}" max="{{ $maxDate }}">
                @error('date') <span class="error">{{ $message }}</span> @enderror

                <select id="time" name="time" wire:model="time" class="form-control">
                    @foreach($timeSlots as $slot)
                    <option value="{{ $slot['displayTime'] }}" @if($slot['isDisabled']) disabled @endif>{{ $slot['displayTime'] }}</option>
                    @endforeach
                </select>
                @error('time') <span class="error">{{ $message }}</span> @enderror

                <input type="number" id="number" name="number" wire:model="number" class="form-control" min="1" max="10">
                @error('number') <span class="error">{{ $message }}</span> @enderror

                <div class="booking-confirm__box">
                    <table>
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
                <div class="layout"></div>
                <div class="edit-booking__footer">
                    <button type="submit" class="booking-submit">予約変更</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showEdited)
    <div class="modal-overlay" wire:click.self="closeEdited">
        <div class="edited">
            <div class="edited__item">
                <span class="edited--logo">予約を変更しました</span>
            </div>
            <div class="edited__item">
                <button type="submit" class="edited--close" wire:click.self="closeEdited">閉じる</button>
            </div>
        </div>
    </div>
    @endif
</div>