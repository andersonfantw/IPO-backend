<?php

namespace App\Http\Middleware;

use App\Client;
use App\ClientBankCard;
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
        Client::where('previewing_by', auth()->user()->name)->update(['previewing_by' => null]);
        ClientBankCard::where('previewing_by', auth()->user()->name)->update(['previewing_by' => null]);
        ClientFundInRequest::where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientHKFundOutRequest::where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientOverseasFundOutRequest::where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        ClientFundInternalTransferRequest::where('previewing_by', auth()->user()->name)->
            update(['previewing_by' => null]);
        return $next($request);
    }
}
