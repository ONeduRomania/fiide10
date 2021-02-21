<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmittedHomework extends Model
{
    use HasFactory;

    public function forHomework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
