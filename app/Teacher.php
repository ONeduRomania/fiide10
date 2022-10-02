<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

// One-To-Many

/**
 * App\Teacher
 *
 * @property int $id
 * @property int $user_id
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUserId($value)
 * @mixin \Eloquent
 */
class Teacher extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'school_id'
    ];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $school_id) {
        return Cache::tags('teachers')->remember('teachers_page_' . $school_id . '_' . $whichpage, $datetime, function () use ($perpage, $school_id) {
            return self::with('user')->where('school_id', $school_id)->paginate($perpage);
        });
    }

    public function user() {
        return $this->belongsTo('App\User')->whereNull('users.deleted_at');;
    }
}
