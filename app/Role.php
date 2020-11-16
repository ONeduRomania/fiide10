<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieModel;
use Illuminate\Support\Facades\Cache;

class Role extends SpatieModel
{
    use HasFactory;

    public static function allWithCache() {
        return Cache::rememberForever('roles', function () {
            return self::all();
        });
    }
}
