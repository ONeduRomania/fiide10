<?php


namespace App\Http\Requests\Log;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarkRequest extends FormRequest
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
            'mark' => ['required', 'numeric', 'between:1,10'],
            'subject' => ['required', 'numeric', 'exists:subjects,id'],
            'term' => ['required', 'numeric', 'between:1,2'],
            'student' => ['required', 'numeric', 'exists:students,id'],
            'date_absence' => ['required', 'date'],
        ];
    }
}
