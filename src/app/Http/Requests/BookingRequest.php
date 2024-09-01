<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date', 'after:today', 'before:90 days'],
            'time' => ['required', 'date_format:H:i', 'after:1 hour'],
            'number' => ['required', 'integer', 'max:10']
        ];
    }
}
