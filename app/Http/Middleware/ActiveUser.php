<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponce;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
  public $auth;

  public function __construct (Guard $auth) {

  $this->auth = $auth;

  }


  public function handle($request, Closure $next)
    {
       if ($this->auth->check()) {

          if ($this->auth->user()->active == true) {

           return $next($request);
            }

        }
       
        return $next($request);
    }
}
