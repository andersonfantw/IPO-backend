<?php

namespace App\Http\Controllers;

use App\ClientFundInRequest;
use Illuminate\Http\Request;

class ClientFundInRequestsController extends HomeController
{
    protected $name = 'ClientFundInRequests';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['field' => '帳戶號碼', 'header' => '帳戶號碼'],
            ['field' => '客户姓名', 'header' => '客户姓名'],
            ['field' => '手機號碼', 'header' => '手機號碼'],
            ['field' => '狀態', 'header' => '狀態'],
            ['field' => '發送時間', 'header' => '發送時間'],
            ['field' => '經手人', 'header' => '經手人'],
            ['field' => '審批時間', 'header' => '審批時間'],
        ];
        $filterMatchMode = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '狀態' => 'equals',
            '經手人' => 'startsWith',
            '發送時間' => 'equals',
            '審批時間' => 'equals',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['filterMatchMode'] = json_encode($filterMatchMode);
        $parameters['User'] = auth()->user()->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function getData(Request $request)
    {
        // $Clients = Client::has('ClientFundInRequests')->orderBy('created_at', 'asc')->get();
        $ClientFundInRequests = ClientFundInRequest::orderBy('created_at', 'asc')->get();
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
            $row['狀態'] = $ClientFundInRequest->status;
            $row['發送時間'] = date_format($ClientFundInRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientFundInRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientFundInRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientFundInRequest->id;
            $rows[] = $row;
        }
        return encrypt(json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE));
        // return json_encode([
        //     'data' => $rows,
        // ], JSON_UNESCAPED_UNICODE);
    }
}
