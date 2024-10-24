<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;

class ApiRateLimiting
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, Closure $next)
    {
        $key = sprintf('api-limit:%s', $request->ip());

        if ($this->limiter->tooManyAttempts($key, 60)) {
            return response()->json([
                'error' => 'Too Many Requests',
                'message' => 'Please try again later.'
            ], 429);
        }

        $this->limiter->hit($key, 60);

        return $next($request);
    }
}
