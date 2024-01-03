<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class blockUserToMakePayment
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
        if (auth()->user()->billing_ends > date('Y-m-d')) {
            return redirect()->route('dashboard')->with('message', 'You are already a premium user.');
        }
        return $next($request);
    }
}
