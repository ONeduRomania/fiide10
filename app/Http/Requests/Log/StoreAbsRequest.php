<?php

namespace App\Http\Requests\Log;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAbsRequest extends FormRequest
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
        return [
            'subject' => ['required', 'numeric', 'exists:subjects,id'],
            'markSwitch' => ['required', 'string', Rule::in(['mark', 'absence'])],
            'mark' => ['exclude_unless:markSwitch,mark', 'required', 'numeric', 'between:1,10'],
            'student' => ['required', 'numeric', 'exists:students,user_id'],
            'date' => ['required', 'date'],
        ];
    }
}
