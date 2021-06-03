<?php

namespace App\Http\Controllers;

use App\ClientOverseasFundOutRequest;
use App\Traits\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClientOverseasFundOutRequestsController extends HomeController
{
    use Excel;

    protected $name = 'ClientOverseasFundOutRequests';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '發送時間', 'sortable' => true],
            ['key' => '經手人', 'sortable' => true],
            ['key' => '審批時間', 'sortable' => true],
            ['key' => '操作'],
        ];
        $FilterType = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '狀態' => 'equals',
            '發送時間' => 'between',
            '經手人' => 'startsWith',
            '審批時間' => 'between',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        $parameters['User'] = auth()->user()->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $ClientOverseasFundOutRequests = ClientOverseasFundOutRequest::whereHas('ClientBankCard', function (Builder $query) {
            $query->whereIn('status', ['audited2', 'approved']);
        })->orderBy('created_at', 'asc')->get();
        $rows = [];
        foreach ($ClientOverseasFundOutRequests as $ClientOverseasFundOutRequest) {
            $Client = $ClientOverseasFundOutRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['狀態'] = $ClientOverseasFundOutRequest->status;
            $row['發送時間'] = date_format($ClientOverseasFundOutRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientOverseasFundOutRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientOverseasFundOutRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientOverseasFundOutRequest->id;
            $rows[] = $row;
        }
        return encrypt(json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE));
        // return json_encode([
        //     'data' => $rows,
        // ], JSON_UNESCAPED_UNICODE);
    }

    public function downloadAyersImportData(Request $request)
    {
        return $this->exportClientOverseasFundOutRequests();
    }
}
