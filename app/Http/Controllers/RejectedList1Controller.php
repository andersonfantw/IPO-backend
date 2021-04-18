<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class RejectedList1Controller extends HomeController
{
    protected $name = 'RejectedList1';
    private $columnNames;

    public function __construct()
    {
        parent::__construct();
        $this->columnNames = [
            // 'userCount' => '是否已有账户',
            // 'chequeReceipt' => '是否上传收据',
            'idCard' => '證件號碼',
            'mobile' => '手機號碼',
            'residenceAddr' => '所在地',
            'email' => '郵箱',
            'lastTime' => '提交時間',
            'relation' => '客户姓名',
            'uuid' => '唯一编码'];
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['field' => '客户姓名', 'header' => '客户姓名'],
            // ['field' => '是否上传收据', 'header' => '是否上传收据'],
            ['field' => '證件號碼', 'header' => '證件號碼'],
            ['field' => '手機號碼', 'header' => '手機號碼'],
            ['field' => '所在地', 'header' => '所在地'],
            ['field' => '郵箱', 'header' => '郵箱'],
            ['field' => '提交時間', 'header' => '提交時間'],
        ];
        $filterMatchMode = [
            '客户姓名' => 'startsWith',
            // '是否已有账户' => 'equals', '是否上传收据' => 'equals',
            '證件號碼' => 'startsWith', '手機號碼' => 'startsWith',
            '所在地' => 'equals', '郵箱' => 'equals',
            '认领时间' => 'equals', '提交時間' => 'equals',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['filterMatchMode'] = json_encode($filterMatchMode);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::has('EditableSteps')->orderBy('created_at', 'desc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $row['客户姓名'] = $Client->ViewClientIDCard->name_c;
            $row['證件號碼'] = $Client->ViewClientIDCard->idcard_no;
            $row['所在地'] = $Client->ViewClientIDCard->address;
            $row['手機號碼'] = $Client->mobile;
            $row['郵箱'] = $Client->email;
            $row['提交時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $rows[] = $row;
        }
        return encrypt(json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE));
        // return json_encode([
        //     'data' => $rs,
        // ], JSON_UNESCAPED_UNICODE);
    }
}
