<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
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
        $schoolId = $this->school_id ?? null;
        return [
            'name' => 'required|min:2|max:50|unique:schools,name,'.$schoolId.',id',
            'code' => 'required|min:1|max:10|unique:schools,code,'.$schoolId.',id',
            'district_id' => 'required',
            'email' => 'required|email|max:50|unique:schools,email,'.$schoolId.',id',
            'type' => ['nullable', Rule::in(array_keys(config('constants.schoolTypes')))],
            'phone' => 'nullable|min:10|max:14|unique:schools,phone,'.$schoolId.',id',
            'fax' => 'nullable|min:10|max:14|unique:schools,fax,'.$schoolId.',id',
        ];
    }
}
