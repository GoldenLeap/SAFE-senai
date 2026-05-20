<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToCorrectPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {
            $currentPanel = Filament::getCurrentPanel();
            
            if ($currentPanel) {
                $currentPanelId = $currentPanel->getId();
                $expectedPanelId = $user->cargo; // 'admin', 'aqv', 'portaria', 'professor'

                // If the user is trying to access a panel different from their designated role,
                // we redirect them to their correct panel home page.
                if ($currentPanelId !== $expectedPanelId) {
                    $url = match ($user->cargo) {
                        'admin' => '/admin',
                        'aqv' => '/aqv',
                        'portaria' => '/portaria',
                        'professor' => '/professor',
                        default => '/',
                    };

                    return redirect($url);
                }
            }
        }

        return $next($request);
    }
}
