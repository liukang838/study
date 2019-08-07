<?php

namespace App\Http\Middleware;

use Closure;

class ReaderAuthenticate
{
    protected $guard = 'reader';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->guard = 'reader';

        if (\Auth::guard($this->guard)->guest()) {

        }
        return $next($request);
    }
}
