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
            ['key' => '操作'],
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '證件號碼', 'sortable' => true],
            ['key' => '電郵', 'sortable' => true],
            ['key' => '投遞日期', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '電郵發送者', 'sortable' => true],
            ['key' => '電郵發送時間', 'sortable' => true],
        ];
        $FilterType = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '電郵' => 'startsWith',
            '投遞日期' => 'between',
            '狀態' => 'equals',
            '電郵發送者' => 'startsWith',
            '電郵發送時間' => 'between',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        $parameters['User'] = auth()->user()->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::has('AyersAccounts')->where('type', '拼一手')->orderBy('created_at', 'asc')->get();
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
