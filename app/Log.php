<?php


namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Log
 *
 * @property int $id
 * @property string $subject
 * @property string $type
 * @property string $student
 * @property string $teacher
 * @property mixed $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $masterTeacher
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
