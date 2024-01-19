<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MultiRole
{
    public $attributes;
    public function handle(Request $request, Closure $next, $roles)
    {   
        $roles = explode("|", $roles);
        foreach ($roles as $role) {
            if(auth()->user()->role == $role){
                $request->attributes->add(['role' => $role]);
                return $next($request);
            }
        }
          
        return abort(404);
    }
}
