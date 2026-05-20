<?php

namespace App\Policies;

use App\Models\Disciplina;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DisciplinaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Disciplina $disciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Disciplina $disciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Disciplina $disciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Disciplina $disciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Disciplina $disciplina): bool
    {
        return $user->cargo === 'admin';
    }
}
