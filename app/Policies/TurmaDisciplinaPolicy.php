<?php

namespace App\Policies;

use App\Models\TurmaDisciplina;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TurmaDisciplinaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TurmaDisciplina $turmaDisciplina): bool
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
    public function update(User $user, TurmaDisciplina $turmaDisciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TurmaDisciplina $turmaDisciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TurmaDisciplina $turmaDisciplina): bool
    {
        return $user->cargo === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TurmaDisciplina $turmaDisciplina): bool
    {
        return $user->cargo === 'admin';
    }
}
