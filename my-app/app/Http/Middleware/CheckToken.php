<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if($request->input('token') !== 'abc'){
        //     return redirect('/');
        // }
        // if($role === 'admin'){
        //     dd('checkToken para admin');
        // }else if($role === 'editor'){
        //     dd('checkToken para editor');
        // }
        dd('teste');
        return $next($request);
    }
}
