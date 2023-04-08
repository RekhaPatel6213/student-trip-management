<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->user_id ?? null;
        return [
            'first_name' => 'required|min:2|max:30',
            'last_name' => 'required|min:2|max:30',
            'email' => 'nullable|email|max:50|unique:users,email,'.$userId.',id',
            'role_id' => 'required',
            'birth_date' => 'date|nullable',
            'phone' => 'nullable|min:10|max:14|unique:users,phone,'.$userId.',id',
            'fax' => 'nullable|min:10|max:14|unique:users,fax,'.$userId.',id',
            'c_street' => 'nullable',
            'c_state_id' => 'nullable',
            'c_city_id' => 'nullable',
            'c_zip' => 'nullable',
            'p_street' => 'nullable',
            'p_state_id' => 'nullable',
            'p_city_id' => 'nullable',
            'p_zip' => 'nullable',
        ];
    }
}
