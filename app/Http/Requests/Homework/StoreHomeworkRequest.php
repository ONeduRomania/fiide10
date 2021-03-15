<?php

namespace App\Http\Requests\Homework;

use App\Teacher;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreHomeworkRequest
 * @package App\Http\Requests\Homework
 *
 * @property string $name
 * @property string $due_date
 * @property string accept_word_upload
 * @property string accept_pdf_upload
 * @property string accept_image_upload
 * @property string accept_code_upload
 * @property string accept_archive_upload
 */
class StoreHomeworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO: Enable for admins as well?
        // TODO: Check if teacher is for the specified subject?

        /** @var User $currentUser */
        $currentUser = $this->user();
        $isTeacher = Teacher::query()->where('user_id', $currentUser->id)->exists();
        return $isTeacher;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'due_date' => ['required', 'date', 'after_or_equal:today']
        ];
    }
}
