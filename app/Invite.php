<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Invite
 *
 * @property int $id
 * @property string $code
 * @property int|null $class_id
 * @property int $school_id
 * @property int $action Daca este 1->invite profesor, daca este 2->invite elev
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Invite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'school_id', 'action', 'class_id'
    ];
}
