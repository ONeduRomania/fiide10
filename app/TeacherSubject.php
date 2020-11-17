<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeacherSubject extends Pivot
{
    protected $table = 'teacher_subjects';
    protected $fillable = [
        'teacher_id', 'subject_id'
    ];
}
