<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
