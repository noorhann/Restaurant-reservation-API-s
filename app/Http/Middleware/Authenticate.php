<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;



use Illuminate\Contracts\Auth\Factory as Auth;

use Request;
use Closure;

class Authenticate extends Middleware
{

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->guard('api')->check()) {
            return $next($request);
        }

        return apiResponse(
            false,
            'Unauthorized user',
            401,
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
