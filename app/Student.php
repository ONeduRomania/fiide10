<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
