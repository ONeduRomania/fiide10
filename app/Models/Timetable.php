<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Timetable.
 *
 * @property int                             $id
 * @property int                             $class_id
 * @property int                             $subject_id
 * @property mixed                           $data
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \App\Models\Classroom           $classes
 * @property \App\Models\Subject             $subjects
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Timetable extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'subject_id', 'data', 'teacher_id'];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $classId)
    {
        return Cache::tags('timetables')->remember('timetables_page_'.$whichpage, $datetime, function () use ($perpage, $classId) {
            return self::with('classrooms')->where('class_id', $classId)->paginate($perpage);
        });
    }

    public function classes()
    {
        return $this->belongsTo('App\Models\Classroom', 'class_id');
    }

    public function subjects()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id');
    }
}
