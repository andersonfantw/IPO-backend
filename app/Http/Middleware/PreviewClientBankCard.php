<?php

namespace App\Http\Middleware;

use App\ClientBankCard;
use Closure;

class PreviewClientBankCard
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
        $ClientBankCard = ClientBankCard::where('account_no', $request->input('account_no'))->
            where('status', 'pending')->where(function ($query) {
            $query->whereNull('previewing_by')->orWhere('previewing_by', auth()->user()->name);
        })->update(['previewing_by' => auth()->user()->name]);
        if ($ClientBankCard > 0) {
            return $next($request);
        } else {
            return back();
        }
    }
}
