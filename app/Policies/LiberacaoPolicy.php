<?php

namespace App\Policies;

use App\Models\Liberacao;
use App\Models\User;

class LiberacaoPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->cargo, ['admin', 'aqv', 'portaria', 'professor']);
    }

    public function view(User $user, Liberacao $liberacao): bool
    {
        return in_array($user->cargo, ['admin', 'aqv', 'portaria', 'professor']);
    }

    public function create(User $user): bool
    {
        return in_array($user->cargo, ['admin', 'aqv']);
    }

    public function update(User $user, Liberacao $liberacao): bool
    {
        return in_array($user->cargo, ['admin', 'aqv', 'portaria', 'professor']);
    }

    public function delete(User $user, Liberacao $liberacao): bool
    {
        return $user->cargo === 'admin';
    }

    public function restore(User $user, Liberacao $liberacao): bool
    {
        return $user->cargo === 'admin';
    }

    public function forceDelete(User $user, Liberacao $liberacao): bool
    {
        return $user->cargo === 'admin';
    }
}
