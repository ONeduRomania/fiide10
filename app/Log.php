<?php


namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'subject', 'type', 'student', 'teacher'];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $schoolId) {
        return Cache::tags('classrooms')->remember('classrooms_page_' . $whichpage, $datetime, function () use ($perpage, $schoolId) {
            return self::with('masterTeacher')->where('school_id', $schoolId)->paginate($perpage);
        });
    }

    public function masterTeacher() {
        return $this->belongsTo('App\User', 'master_teacher');
    }
}
