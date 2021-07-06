<?php
namespace App\Traits;

use App\Exports\AyersDataExport;
use App\Exports\ClientFundInRequestsExport;
use App\Exports\ClientFundInternalTransferRequestsExport;
use App\Exports\ClientHKFundOutRequestsExport2;
use App\Exports\ClientHKFundOutRequestsExport;
use App\Exports\ClientOverseasFundOutRequestsExport;
use App\Imports\ClientFundInternalTransferRequestsImport;
use Excel as _Excel;
use Storage;

trait Excel
{
    public function exportAyersImportData(array $clients)
    {
        return _Excel::download(new AyersDataExport($clients), 'AyersImportData.xlsx');
    }

    public function exportClientFundInRequests()
    {
        return _Excel::download(new ClientFundInRequestsExport(), 'FundInRequests.xlsx');
    }

    public function exportClientHKFundOutRequests()
    {
        return _Excel::download(new ClientHKFundOutRequestsExport(), 'HKFundOutRequests.xlsx');
    }

    public function exportClientHKFundOutRequests2()
    {
        return _Excel::download(new ClientHKFundOutRequestsExport2(), 'HKFundOutRequests2.xlsx');
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
}
