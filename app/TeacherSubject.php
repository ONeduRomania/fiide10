<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\TeacherSubject
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherSubject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherSubject extends Pivot
{
    protected $table = 'teacher_subjects';
    protected $fillable = [
        'teacher_id', 'subject_id'
    ];
}
