<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UsersObserver
{
    /**
     * Created method of the observer...
     *
     * @param User $user
     */
    public function created(User $user) {
        $user->assignRole('Basic');

        Cache::tags('users')->flush();
    }

    /**
     * Deleted method of the observer...
     *
     * @param User $user
     */
    public function deleted(User $user) {
        Cache::tags('users')->flush();
    }
}
