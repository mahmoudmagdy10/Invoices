<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class checkUserActivation
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
        if(Auth::user()->status == 'مفعل'){
            return $next($request);

        }

        if(Auth::user()->status == 'غير مفعل'){
            return redirect()->back()->with('message','هذا الحساب غير مفعل  الرجاء التواصل مع المسؤول');
        }




    }
}
