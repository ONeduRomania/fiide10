<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Student
 *
 * @property int $id
 * @property int $user_id
 * @property int $class_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUserId($value)
 * @mixin \Eloquent
 */
class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'class_id'
    ];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $class_id) {
        return Cache::tags('students')->remember('students_page_' . $class_id . '_' . $whichpage, $datetime, function () use ($perpage, $class_id) {
            return self::with('user')->where('class_id', $class_id)->paginate($perpage);
        });
    }

    public function user() {
        return $this->belongsTo('App\User')->whereNull('users.deleted_at');
    }
}
