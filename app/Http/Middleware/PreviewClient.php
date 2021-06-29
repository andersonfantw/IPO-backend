<?php

namespace App\Http\Middleware;

use App\Client;
use Closure;

class PreviewClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->
            where('status', '!=', 'audited2')->where(function ($query) {
            $query->whereNull('previewing_by')->orWhere('previewing_by', auth()->user()->name);
        })->update(['previewing_by' => auth()->user()->name]);
        if ($Client > 0) {
            return $next($request);
        } else {
            return back();
        }
    }
}
