<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Cabin;

class CabinRequest extends FormRequest
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
        $cabinId = $this->cabin_id ?? null;
        return [
            'name' => 'required|min:2|max:50|unique:cabins,name,'.$cabinId.',id',
            'code' => 'required|min:1|max:5|unique:cabins,code,'.$cabinId.',id',
            'eligible_student' => 'required|min:1|max:20',
            'gender' => [Rule::in([Cabin::MALE, Cabin::FEMALE])],
            'is_eagle_point' => [Rule::in([Cabin::YES, Cabin::NO])],
        ];
    }
}
