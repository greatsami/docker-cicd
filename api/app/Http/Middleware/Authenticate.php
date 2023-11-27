<?php

namespace App\Http\Middleware;

use Closure;
use Ed9\LaravelDateDirective\Handler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ($user = auth()->user()) {
            $handler = app(Handler::class);
            /** @phpstan-ignore-next-line */
            $handler->set12HourFormat($user->show_time_with_12_hours);
            /** @phpstan-ignore-next-line */
            $handler->setTimezone($user->timezone);
        }
        return parent::handle($request, $next);
    }

}