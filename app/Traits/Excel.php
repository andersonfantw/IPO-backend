<?php

namespace App\Traits;

use App\Exports\AyersDataExport;
use App\Exports\OpenAccountDepositExport;
use App\Exports\ClientFundInRequestsExport;
use App\Exports\ClientFundInternalTransferRequestsExport;
use App\Exports\ClientHKFundOutRequestsExport2;
use App\Exports\ClientHKFundOutRequestsExport;
use App\Exports\ClientOverseasFundOutRequestsExport;
use App\Exports\UnknownDepositsExport;
use App\Imports\ClientFundInternalTransferRequestsImport;
use Excel as _Excel;
use Storage;

trait Excel
{
    public function exportAyersImportData(array $clients)
    {
        return _Excel::download(new AyersDataExport($clients), 'AyersImportData.xlsx');
    }

    public function exportOpenAccountDeposit(array $clients)
    {
        return _Excel::download(new OpenAccountDepositExport($clients), 'OpenAccountDeposit.xlsx');
    }

    public function exportClientFundInRequests()
    {
        return _Excel::download(new ClientFundInRequestsExport(), 'FundInRequests.xls');
    }

    public function exportClientFundInRequests2()
    {
        return _Excel::download(new ClientFundInRequestsExport2(), 'FundInRequests2.xls');
    }

    public function exportClientHKFundOutRequests()
    {
        return _Excel::download(new ClientHKFundOutRequestsExport(), 'HKFundOutRequests.xls');
    }

    public function exportClientHKFundOutRequests2()
    {
        return _Excel::download(new ClientHKFundOutRequestsExport2(), 'HKFundOutRequests2.xls');
    }

    public function exportClientOverseasFundOutRequests()
    {
        return _Excel::download(new ClientOverseasFundOutRequestsExport(), 'OverseasFundOutRequests.xlsx');
    }

    public function exportClientFundInternalTransferFundOutRequests()
    {
        return _Excel::download(new ClientFundInternalTransferRequestsExport(), 'FundInternalTransferFundOutRequests.xlsx');
    }

    public function exportClientFundInternalTransferFundInRequests()
    {
        return _Excel::download(new ClientFundInternalTransferRequestsImport(), 'FundInternalTransferFundInRequests.xlsx');
    }

    public function exportUnknownDeposits(String $uploaded_at)
    {
        return _Excel::download(new UnknownDepositsExport($uploaded_at), "UnknownDeposits$uploaded_at.xlsx");
    }
}
