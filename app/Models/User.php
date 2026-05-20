<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;


#[Fillable(['nome','cargo', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser, FilamentUser, HasName
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }


    // Se for AQV, traz as liberações criadas
    public function liberacoesCriadas()
    {
        return $this->hasMany(Liberacao::class, 'aqv_id');
    }

    // Se for um aluno, traz as turmas dele
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'aluno_turma', 'aluno_id', 'turma_id');
    }

    // Se for um professor, traz as escalas dele
    public function escalas(){
        return $this->hasMany(EscalaProfessor::class, 'professor_id');

    }

    public function canAccessPanel(Panel $panel): bool
    {
        // O painel admin serve como login central para todos os cargos.
        // O middleware RedirectToCorrectPanel cuida de redirecionar
        // cada usuário para o painel correto após o login.
        if ($panel->getId() === 'admin') {
            return in_array($this->cargo, ['admin', 'aqv', 'portaria', 'professor']);
        }
        if ($panel->getId() === 'professor') {
            return $this->cargo === 'professor';
        }
        if ($panel->getId() === 'portaria') {
            return $this->cargo === 'portaria';
        }
        if ($panel->getId() === 'aqv') {
            return $this->cargo === 'aqv';
        }
        return false;
    }

    public function getFilamentName(): string
    {
        return $this->nome;
    }
}
