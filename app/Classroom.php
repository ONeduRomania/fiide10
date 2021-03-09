<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Classroom
 *
 * @property int $id
 * @property string $name
 * @property int $school_id
 * @property int $master_teacher DIRIGINTE CLASA
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $masterTeacher
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereMasterTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Classroom extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'master_teacher', 'school_id'];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $schoolId) {
        return Cache::tags('classrooms')->remember('classrooms_page_' . $whichpage, $datetime, function () use ($perpage, $schoolId) {
            return self::with('masterTeacher')->where('school_id', $schoolId)->paginate($perpage);
        });
    }

    public function masterTeacher() {
        return $this->belongsTo('App\User', 'master_teacher');
    }
}
