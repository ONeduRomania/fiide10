<?php

namespace App\Http\Requests;

use App\Homework;
use App\Student;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Homework|null homework
 */
class SubmitHomeworkRequest extends FormRequest
{
    /**
     * @var Student|null
     */
    public $student;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Homework|null $homework */
        $homework = $this->homework;

        /** @var User $user */
        $user = $this->user();

        /** @var Student|null $student */
        $student = Student::where('user_id', $user->id)->first();
        if ($student == null) {
            return false;
        }
        $this->student = $student;

        return $student->class_id === $homework->class_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /** @var Homework|null $homework */
        $homework = $this->homework;
        $types = json_decode($homework->filetypes, true);
        $typeStr = implode(",", $types);
        return [
            'file' => 'required|mimes:' . $typeStr . "|max:" . env("MAX_HOMEWORK_FILESIZE_KB", 51200)
        ];
    }
}
