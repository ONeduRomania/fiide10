<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

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
