<?php


namespace App\Http\Requests\Timetable;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimetableRequest extends FormRequest
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
            'subject' => ['required', 'numeric', 'exists:subjects,id'],
            'class_id' => ['required', 'numeric', 'exists:classrooms,id'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['class_id'] = $this->route('class.id');

        return $data;
    }
}
