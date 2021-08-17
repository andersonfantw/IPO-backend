<?php

namespace App\Http\Controllers;

use App\ClientFundInRequest;
use App\Traits\Excel;
use Illuminate\Http\Request;

class ClientFundInRequestsController extends HomeController
{
    use Excel;

    protected $name = 'ClientFundInRequests';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '銀行', 'sortable' => true],
            ['key' => '金額', 'sortable' => true],
            ['key' => '方法', 'sortable' => true],
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
            '銀行' => 'equals',
            '金額' => 'equals',
            '方法' => 'equals',
            '狀態' => 'equals',
            '發送時間' => 'betweenDate',
            '經手人' => 'startsWith',
            '審批時間' => 'betweenDate',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        $parameters['User'] = auth()->user()->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function list(Request $request)
    {
        $ClientFundInRequests = ClientFundInRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientFundInRequests as $ClientFundInRequest) {
            $Client = $ClientFundInRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['銀行'] = $ClientFundInRequest->bank;
            $row['方法'] = $ClientFundInRequest->method;
            $row['金額'] = $ClientFundInRequest->amount;
            $row['狀態'] = $ClientFundInRequest->status;
            $row['發送時間'] = date_format($ClientFundInRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientFundInRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientFundInRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientFundInRequest->id;
            $rows[] = $row;
        }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function downloadAyersImportData(Request $request)
    {
        return $this->exportClientFundInRequests();
    }

    public function downloadAyersImportData2(Request $request)
    {

    }
}
