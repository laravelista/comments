<?php namespace Laravelista\Comments\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Laravelista\Syndra\Syndra;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    protected $syndra;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth, Syndra $syndra)
    {
        $this->auth = $auth;
        $this->syndra = $syndra;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            return $this->syndra->respondUnauthorized();
        }

        return $next($request);
    }
}
