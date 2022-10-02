<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\SubmittedHomework
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $student_id
 * @property int $homework_id
 * @property mixed $uploaded_urls
 * @property string|null $additional_info
 * @property-read \App\Homework $forHomework
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereAdditionalInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereHomeworkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubmittedHomework whereUploadedUrls($value)
 * @mixin \Eloquent
 */
class SubmittedHomework extends Model
{
    use HasFactory;

    public function forHomework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
