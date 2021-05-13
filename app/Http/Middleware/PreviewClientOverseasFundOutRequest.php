<?php

namespace App\Http\Middleware;

use App\ClientOverseasFundOutRequest;
use Closure;

class PreviewClientOverseasFundOutRequest
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
        $ClientOverseasFundOutRequest = ClientOverseasFundOutRequest::where('id', $request->input('id'))->
            where('status', 'pending')->where(function ($query) {
            $query->whereNull('previewing_by')->orWhere('previewing_by', auth()->user()->name);
        })->update(['previewing_by' => auth()->user()->name]);
        if ($ClientOverseasFundOutRequest > 0) {
            return $next($request);
        } else {
            return back();
        }
    }
}
