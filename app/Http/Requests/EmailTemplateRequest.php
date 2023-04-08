<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailTemplateRequest extends FormRequest
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
        $emailTemplateId = $this->emailTemplate_id ?? null;
        return [
            'subject' => 'required|max:255|unique:email_templates,subject,'.$emailTemplateId.',id',
            'message' => 'required',
            'status' => ['nullable', Rule::in(['ACTIVE','INACTIVE'])],
        ];
    }
}
