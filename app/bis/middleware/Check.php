<?php

namespace app\bis\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        if(session('?bisAccount')) {
            return $next($request);
        }else{
            return redirect(url('login/index'));
        }
    }
}
