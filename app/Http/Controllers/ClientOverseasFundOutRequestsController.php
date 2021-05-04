<?php

namespace App\Http\Controllers;

use App\ClientOverseasFundOutRequest;
use Illuminate\Http\Request;

class ClientOverseasFundOutRequestsController extends HomeController
{
    protected $name = 'ClientOverseasFundOutRequests';

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
        $ClientOverseasFundOutRequests = ClientOverseasFundOutRequest::orderBy('created_at', 'asc')->get();
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
            $row['發送時間'] = $ClientOverseasFundOutRequest->created_at;
            $row['經手人'] = $ClientOverseasFundOutRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : $ClientOverseasFundOutRequest->updated_at;
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
}
