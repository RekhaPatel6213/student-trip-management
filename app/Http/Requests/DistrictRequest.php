<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
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
        $districtId = $this->district_id ?? null;
        return [
            'name' => 'required|min:2|max:50|unique:districts,name,'.$districtId.',id',
            'code' => 'required|min:1|max:5|unique:districts,code,'.$districtId.',id',
        ];
    }
}
