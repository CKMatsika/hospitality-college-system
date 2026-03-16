<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
        return $user->hasRole('admin') || $user->hasRole('staff');
    }

    public function manage(User $user, Application $application): bool
    {
        return $user->hasRole('admin') || $user->hasRole('staff');
    }
}
