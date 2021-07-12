<?php

namespace App\Http\Controllers;

use App\ClientBankCard;
use Illuminate\Http\Request;

class ClientBankCardsController extends HomeController
{
    protected $name = 'ClientBankCards';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '地區', 'sortable' => true],
            ['key' => '銀行', 'sortable' => true],
            ['key' => '銀行戶口', 'sortable' => true],
            ['key' => '發送時間', 'sortable' => true],
            ['key' => '經手人', 'sortable' => true],
            ['key' => '審批時間', 'sortable' => true],
            ['key' => '操作'],
        ];
        $FilterType = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '地區' => 'equals',
            '銀行' => 'startsWith',
            '銀行戶口' => 'equals',
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
        $ClientBankCards = ClientBankCard::whereIn('status', ['pending', 'approved'])->get();
        $rows = [];
        foreach ($ClientBankCards as $ClientBankCard) {
            $Client = $ClientBankCard->Client;
            if ($Client->status != 'audited2') {
                continue;
            }
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['地區'] = $ClientBankCard->lcid;
            $row['銀行'] = $ClientBankCard->bank_name;
            $row['銀行戶口'] = $ClientBankCard->account_no;
            $row['發送時間'] = date_format($ClientBankCard->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientBankCard->issued_by;
            $row['狀態'] = $ClientBankCard->status;
            $row['審批時間'] = $ClientBankCard->status == 'pending' ? null : date_format($ClientBankCard->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientBankCard->id;
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
