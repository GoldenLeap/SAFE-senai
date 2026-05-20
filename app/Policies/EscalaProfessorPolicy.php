<?php

namespace App\Policies;

use App\Models\EscalaProfessor;
use App\Models\User;

class EscalaProfessorPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->cargo, ['admin', 'aqv', 'portaria', 'professor']);
    }

    public function view(User $user, EscalaProfessor $escala): bool
    {
        return in_array($user->cargo, ['admin', 'aqv', 'portaria', 'professor']);
    }

    public function create(User $user): bool
    {
        return $user->cargo === 'admin';
    }

    public function update(User $user, EscalaProfessor $escala): bool
    {
        return $user->cargo === 'admin';
    }

    public function delete(User $user, EscalaProfessor $escala): bool
    {
        return $user->cargo === 'admin';
    }

    public function restore(User $user, EscalaProfessor $escala): bool
    {
        return $user->cargo === 'admin';
    }

    public function forceDelete(User $user, EscalaProfessor $escala): bool
    {
        return $user->cargo === 'admin';
    }
}
