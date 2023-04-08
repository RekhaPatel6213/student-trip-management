<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Administrator;

class AdministratorRequest extends FormRequest
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
        $administratorId = $this->administrator_id ?? null;
        $schoolId = $this->school_id ?? null;
        return [
            'first_name' => 'required|min:2|max:30',
            'last_name' => 'required|min:2|max:30',
            'email' => 'required|email|max:50|unique:administrators,email,'.$administratorId.',id',
            'title' => ['required', Rule::in(array_keys(config('constants.administratorTitles')))],
            'position' => ['required', Rule::in(array_keys(config('constants.administratorPositions'))), 'unique:administrators,position,'.$administratorId.',id,school_id,'.$schoolId],
            'district_id' => 'required',
            'school_id' => 'required',
            'school2' => 'nullable|max:50',
            'phone' => 'required|min:10|max:14|unique:administrators,phone,'.$administratorId.',id',
            'fax' => 'nullable|min:10|max:14|unique:administrators,fax,'.$administratorId.',id',
            'address' => 'required|max:255',
            'city_id' => 'required',
            'state_id' => 'required',
            'zip' => 'required',
            'comments' => 'nullable',
        ];
    }
}
