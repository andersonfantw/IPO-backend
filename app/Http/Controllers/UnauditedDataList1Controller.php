<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class UnauditedDataList1Controller extends HomeController
{
    private $columnNames;

    public function __construct()
    {
        parent::__construct();
        $this->columnNames = [
            // 'userCount' => '是否已有账户',
            'chequeReceipt' => '是否上传收据',
            'idCard' => '证件号码',
            'mobile' => '手机号码',
            'residenceAddr' => '所在地',
            'email' => '邮箱',
            'lastTime' => '提交时间',
            'relation' => '客户姓名',
            'uuid' => '唯一编码'];
    }

    public function main(Request $request)
    {
        $columns = [['field' => '客户姓名', 'header' => '客户姓名'],
            // ['field' => '是否已有账户', 'header' => '是否已有账户'],
            ['field' => '是否上传收据', 'header' => '是否上传收据'],
            ['field' => '证件号码', 'header' => '证件号码'],
            ['field' => '手机号码', 'header' => '手机号码'],
            ['field' => '所在地', 'header' => '所在地'],
            ['field' => '邮箱', 'header' => '邮箱'],
            // ['field' => '认领时间', 'header' => '认领时间'],
            ['field' => '提交时间', 'header' => '提交时间']];
        $filterMatchMode = ['客户姓名' => 'equals',
            '是否已有账户' => 'equals', '是否上传收据' => 'equals',
            '证件号码' => 'equals', '手机号码' => 'equals',
            '所在地' => 'equals', '邮箱' => 'equals',
            '认领时间' => 'equals', '提交时间' => 'equals'];
        return view('UnauditedDataList1HongKong', ['menu' => json_encode($this->getMenu()),
            'columns' => json_encode($columns), 'filterMatchMode' => json_encode($filterMatchMode)]);
    }

    public function getData(Request $request)
    {
        $Clients = Client::where('status', 'unaudited')
            ->orderBy('created_at', 'desc')
            ->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            foreach ($this->columnNames as $columnKey => $columnName) {
                $row['是否上传收据'] = $Client->clientDepositProof ? '已上传收据' : '未上传收据';
                if ($Client->clientHKIDCard) {
                    $row['客户姓名'] = $Client->clientHKIDCard->name_tc;
                    $row['证件号码'] = $Client->clientHKIDCard->idcard_no;
                } elseif ($Client->clientCNIDCard) {
                    $row['客户姓名'] = $Client->clientCNIDCard->name_sc;
                    $row['证件号码'] = $Client->clientCNIDCard->idcard_no;
                }
                $row['手机号码'] = $Client->mobile;
                if ($Client->clientAddressProof) {
                    $row['所在地'] = $Client->clientAddressProof->detailed_address;
                } else {
                    $row['所在地'] = null;
                }
                $row['邮箱'] = $Client->email;
                $row['提交时间'] = $Client->created_at;
                $row['uuid'] = $Client->uuid;
                // if ($columnName == '客户姓名') {
                //     if ($r->{$columnKey}) {
                //         $row[$columnName] = $Client->clientHKIDCard->name_tc . '(亲属)';
                //     } else {
                //         $row[$columnName] = $r->realName;
                //     }
                // } elseif ($columnName == '是否已有账户') {
                //     if ($r->{$columnKey} > 1) {
                //         $row[$columnName] = "是 (当前为第: " . $r->{$columnKey} . "条)";
                //     } else {
                //         $row[$columnName] = '否';
                //     }
                // } elseif ($columnName == '是否上传收据') {
                //     if ($r->{$columnKey} == '') {
                //         $row[$columnName] = '未上传收据';
                //     } else {
                //         $row[$columnName] = '已上传收据';
                //     }
                // } elseif ($columnName == '所在地') {
                //     if ($r->{$columnKey} == 1) {
                //         $row[$columnName] = $r->idCardAddr;
                //     } elseif ($r->{$columnKey} == 2) {
                //         $row[$columnName] = $r->residenceAddrInfo;
                //     }
                // } else {
                //     $row[$columnName] = $r->{$columnKey};
                // }
            }
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
