<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Trip;

class TripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tripId = $this->trip_id ?? null;
        return [
            'type' => [Rule::in([Trip::WEEK, Trip::DAY])],
            'start_date' => 'required|date|unique:trips,start_date,'.$tripId.',id,type,'.$this->type,
            'description' => 'required|max:255',
            'week_day' => ['nullable', 'required_if:type,'.Trip::WEEK, Rule::in(array_keys(config('constants.weekDays')))],
        ];
    }
}
