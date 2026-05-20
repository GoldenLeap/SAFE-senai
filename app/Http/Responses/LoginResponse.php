<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        $user = auth()->user();

        if ($user) {
            $url = match ($user->cargo) {
                'admin' => '/admin',
                'aqv' => '/aqv',
                'portaria' => '/portaria',
                'professor' => '/professor',
                default => '/',
            };

            return redirect($url);
        }

        return redirect('/');
    }
}
