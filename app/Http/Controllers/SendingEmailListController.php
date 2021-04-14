<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class SendingEmailListController extends HomeController
{
    protected $name = 'SendingEmailList';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['field' => '帳戶號碼', 'header' => '帳戶號碼'],
            ['field' => '客户姓名', 'header' => '客户姓名'],
            ['field' => '證件號碼', 'header' => '證件號碼'],
            // ['field' => '手機號碼', 'header' => '手機號碼'],
            ['field' => '電郵', 'header' => '電郵'],
            ['field' => '投遞日期', 'header' => '投遞日期'],
            ['field' => '狀態', 'header' => '狀態'],
            ['field' => '電郵發送者', 'header' => '電郵發送者'],
            ['field' => '電郵發送時間', 'header' => '電郵發送時間'],
        ];
        $filterMatchMode = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            // '手機號碼' => 'startsWith',
            '電郵' => 'startsWith',
            '投遞日期' => 'equals',
            '狀態' => 'equals',
            '電郵發送者' => 'startsWith',
            '電郵發送時間' => 'equals',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['filterMatchMode'] = json_encode($filterMatchMode);
        $parameters['User'] = auth()->user()->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::has('AyersAccounts')->orderBy('created_at', 'asc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
                $row['投遞日期'] = date_format($AyersAccount->created_at, "Y-m-d");
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['證件號碼'] = $Client->IDCard->idcard_no;
            // $row['手機號碼'] = $Client->mobile;
            $row['電郵'] = $Client->email;
            $SentEmailRecord = $Client->SentEmailRecords->where('type', 'open account email')->first();
            $row['狀態'] = is_object($SentEmailRecord) ? '已發送' : '未發送';
            $row['電郵發送時間'] = is_object($SentEmailRecord) ? date_format($SentEmailRecord->created_at, "Y-m-d H:i:s") : null;
            $row['電郵發送者'] = is_object($SentEmailRecord) ? $SentEmailRecord->sent_by : null;
            $row['uuid'] = $Client->uuid;
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
