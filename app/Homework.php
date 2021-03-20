<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Homework
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $due_date
 * @property string|null $name
 * @property string|null filetypes
 * @property int $teacher_id
 * @property int $subject_id
 * @property int $class_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubmittedHomework[] $submissions
 * @property-read int|null $submissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Homework newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Homework newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Homework query()
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Homework whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Homework extends Model
{
    use HasFactory;

    public function submissions(): HasMany
    {
        return $this->hasMany(SubmittedHomework::class);
    }
}
