<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'invite_id', 'approved', 'declined'
    ];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage, int $invite_id) {
        return Cache::tags('teachers')->remember('teachers_page_' . $invite_id . '_' . $whichpage, $datetime, function () use ($perpage, $invite_id) {
            return self::with('user')->where(['invite_id' => $invite_id, 'approved' => NULL, 'declined' => NULL])->paginate($perpage);
        });
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
