<?php

namespace App\Http\Middleware;

use App\Client;
use App\ClientFundInRequest;
use App\ClientFundInternalTransferRequest;
use App\ClientHKFundOutRequest;
use App\ClientOverseasFundOutRequest;
use Closure;

class ResetPreviewingBy
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
        Client::where('status', '!=', 'audited2')->where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientFundInRequest::where('status', 'pending')->where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientHKFundOutRequest::where('status', 'pending')->where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientOverseasFundOutRequest::where('status', 'pending')->where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientFundInternalTransferRequest::where('status', 'pending')->where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        return $next($request);
    }
}
