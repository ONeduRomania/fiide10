<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SchoolsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // @todo when done with permissions update this...
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'between:7,128'],
            'email_contact' => ['required', 'email', 'unique:schools,email_contact', 'between:8,64'],
            'phone_number' => ['sometimes', 'nullable', 'numeric', 'digits:10'],
            'address_type' => ['sometimes', 'nullable', 'string', 'between:16,128'],
        ];
    }
}
