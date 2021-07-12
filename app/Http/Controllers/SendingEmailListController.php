<?php

namespace App\Http\Controllers;

use App\ViewSendingOpenedACEmail;
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
            '投遞日期' => 'betweenDate',
            '狀態' => 'equals',
            '電郵發送者' => 'startsWith',
            '電郵發送時間' => 'betweenDate',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        $parameters['User'] = auth()->user()->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function getData(Request $request)
    {
        // $Clients = Client::has('AyersAccounts')->where('type', '拼一手')->orderBy('created_at', 'asc')->get();
        $Clients = ViewSendingOpenedACEmail::orderBy('email_sent_at', 'asc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $AyersAccounts = [$Client->ayers_08, $Client->ayers_13];
            $row['投遞日期'] = $Client->ayers_ac_created_at;
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->name_c;
            $row['證件號碼'] = $Client->idcard_no;
            // $row['手機號碼'] = $Client->mobile;
            $row['電郵'] = $Client->email;
            $row['狀態'] = $Client->status;
            $row['電郵發送時間'] = $Client->email_sent_at;
            $row['電郵發送者'] = $Client->sent_by;
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
