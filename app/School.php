<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * App\School
 *
 * @property int $id
 * @property string $name
 * @property string $email_contact
 * @property array|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Query\Builder|School onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEmailContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|School withTrashed()
 * @method static \Illuminate\Database\Query\Builder|School withoutTrashed()
 * @mixin \Eloquent
 */
class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email_contact', 'address'
    ];

    protected $casts = [
        'address' => 'array',
    ];

    public static function allWithCache(Carbon $datetime, int $perpage, int $whichpage) {
        return Cache::tags('schools')->remember('schools_page_' . $whichpage, $datetime, function () use ($perpage) {
            return self::paginate($perpage);
        });
    }

}
