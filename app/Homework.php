<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Homework extends Model
{
    use HasFactory;

    public function submissions(): HasMany
    {
        return $this->hasMany(SubmittedHomework::class);
    }
}
