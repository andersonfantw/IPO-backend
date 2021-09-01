<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'AuditClient',
        'ViewClient',
        'audit1',
        'GenerateAyersAccount',
        'login',
        'AuditClientFundInRequest',
        'AuditClientFundInternalTransferRequest',
        'AuditClientHKFundOutRequest',
        'AuditClientOverseasFundOutRequest',
        'DoAuditClientHKFundOutRequest',
        'DoAuditClientFundInternalTransferRequest',
        'DoAuditClientFundInRequest',
        'DoAuditClientOverseasFundOutRequest',
        'ViewClientHKFundOutRequest',
        'ViewClientFundInternalTransferRequest',
        'ViewClientFundInRequest',
        'ViewClientOverseasFundOutRequest',
        'AuditClientBankCard',
        'ViewClientBankCard',
        'DoAuditClientBankCard',
        'AuditClientCreditCard',
        'ViewClientCreditCard',
        'DoAuditClientCreditCard',
        'CheckingDeposit',
    ];
}
