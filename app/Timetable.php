<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Timetable
 *
 * @property int $id
 * @property int $class_id
 * @property int $subject_id
 * @property mixed $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Classroom $classes
 * @property-read \App\Subject $subjects
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timetable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Timetable extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'subject_id', 'data'];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $classId) {
        return Cache::tags('timetables')->remember('timetables_page_' . $whichpage, $datetime, function () use ($perpage, $classId) {
            return self::with('classrooms')->where('class_id', $classId)->paginate($perpage);
        });
    }

    public function classes() {
        return $this->belongsTo('App\Classroom', 'class_id');
    }

    public function subjects() {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
}
