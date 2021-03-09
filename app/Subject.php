<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Subject
 *
 * @property int $id
 * @property string $name
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'school_id',
    ];

    public static function allCached(Carbon $datetime, int $school_id) {
        return Cache::remember('subject_all_school_' . $school_id, $datetime, function () use ($school_id) {
            return self::where('school_id', $school_id)->get();
        });
    }

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $school_id) {
        return Cache::tags('subjects')->remember('subject_page_' . $school_id . '_' . $whichpage, $datetime, function () use ($perpage, $school_id) {
            return self::where('school_id', $school_id)->paginate($perpage);
        });
    }
}
