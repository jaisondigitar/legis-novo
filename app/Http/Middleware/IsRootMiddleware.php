<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Flash;

class IsRootMiddleware
{

    protected $auth;
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->user()->hasRole('root')) {
            flash('Ops! Sem permissão.')->error();
            return redirect('/');
        }
        return $next($request);
    }
}
