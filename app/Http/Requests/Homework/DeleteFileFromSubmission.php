<?php

namespace App\Http\Requests\Homework;

use App\Student;
use App\SubmittedHomework;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string file_name
 * @property SubmittedHomework|null submission
 */
class DeleteFileFromSubmission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var User|null $currentUser */
        $currentUser = $this->user();
        if ($currentUser == null) {
            return false;
        }

        $student = Student::where('user_id', $currentUser->id)->first();
        if ($student == null) {
            // TODO: Maybe allow admins and teachers?
            return false;
        }

        $submission = SubmittedHomework::where('homework_id', $this->homework->id)->where('student_id', $student->id)->first();
        if ($submission == null) {
            return false;
        }

        $this->submission = $submission;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file_name' => 'required'
        ];
    }
}
