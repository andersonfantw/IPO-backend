<?php

namespace App\Http\Controllers;

use App\ClientHKFundOutRequest;
use App\Traits\Excel;
use Illuminate\Http\Request;

class ClientHKFundOutRequestsController extends HomeController
{
    use Excel;

    protected $name = 'ClientHKFundOutRequests';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '銀行', 'sortable' => true],
            ['key' => '金額', 'sortable' => true],
            // ['key' => '銀行帳戶', 'sortable' => true],
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
            // '銀行帳戶' => 'startsWith',
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

    public function getData(Request $request)
    {
        // $yesterday = today()->subDays(3)->toDateString();
        $ClientHKFundOutRequests = ClientHKFundOutRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientHKFundOutRequests as $ClientHKFundOutRequest) {
            $Client = $ClientHKFundOutRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['銀行'] = $ClientHKFundOutRequest->bank;
            // $row['銀行帳戶'] = $ClientHKFundOutRequest->account_in;
            $row['金額'] = number_format($ClientHKFundOutRequest->amount, 2, '.', '');
            $row['狀態'] = $ClientHKFundOutRequest->status;
            $row['發送時間'] = date_format($ClientHKFundOutRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientHKFundOutRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientHKFundOutRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientHKFundOutRequest->id;
            $rows[] = $row;
        }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function downloadAyersImportData(Request $request)
    {
        return $this->exportClientHKFundOutRequests();
    }

    public function downloadAyersImportData2(Request $request)
    {
        return $this->exportClientHKFundOutRequests2();
    }
}
