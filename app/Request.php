<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Request
 *
 * @property int $id
 * @property int $user_id
 * @property int $invite_id
 * @property string|null $approved
 * @property string|null $declined
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request query()
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereInviteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereUserId($value)
 * @mixin \Eloquent
 */
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
