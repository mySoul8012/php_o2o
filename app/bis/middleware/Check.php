<?php

namespace app\bis\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        dump(session('?bisAccount'));
        return $next($request);
    }
}
