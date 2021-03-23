<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use Illuminate\Database\Eloquent\Builder;
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
            'chequeReceipt' => '是否上传收据',
            'idCard' => '证件号码',
            'mobile' => '手机号码',
            'residenceAddr' => '所在地',
            'email' => '邮箱',
            'lastTime' => '提交时间',
            'relation' => '客户姓名',
            'uuid' => '唯一编码'];
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [['field' => '客户姓名', 'header' => '客户姓名'],
            ['field' => '是否上传收据', 'header' => '是否上传收据'],
            ['field' => '证件号码', 'header' => '证件号码'],
            ['field' => '手机号码', 'header' => '手机号码'],
            ['field' => '所在地', 'header' => '所在地'],
            ['field' => '邮箱', 'header' => '邮箱'],
            ['field' => '提交时间', 'header' => '提交时间']];
        $filterMatchMode = ['客户姓名' => 'startsWith',
            '是否已有账户' => 'equals', '是否上传收据' => 'equals',
            '证件号码' => 'startsWith', '手机号码' => 'startsWith',
            '所在地' => 'equals', '邮箱' => 'equals',
            '认领时间' => 'equals', '提交时间' => 'equals'];
        $parameters['columns'] = json_encode($columns);
        $parameters['filterMatchMode'] = json_encode($filterMatchMode);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhereHas('clientBankCard', function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhereHas('clientWorkingStatus', function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhereHas('clientFinancialStatus', function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhereHas('clientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhereHas('clientEvaluationResults', function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhereHas('clientSignature', function (Builder $query) {
            $query->where('status', 'rejected');
        })->orWhere('status', 'rejected')->orderBy('created_at', 'desc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            foreach ($this->columnNames as $columnKey => $columnName) {
                $row['是否上传收据'] = $Client->clientDepositProof ? '已上传收据' : '未上传收据';
                if ($Client->idcard_type == ClientHKIDCard::class) {
                    $row['客户姓名'] = $Client->IDCard->name_tc;
                    $row['证件号码'] = $Client->IDCard->idcard_no;
                } elseif ($Client->idcard_type == ClientCNIDCard::class) {
                    $row['客户姓名'] = $Client->IDCard->name_sc;
                    $row['证件号码'] = $Client->IDCard->idcard_no;
                    $row['所在地'] = $Client->IDCard->idcard_address;
                }
                $row['手机号码'] = $Client->mobile;
                if ($Client->clientAddressProof) {
                    $row['所在地'] = $Client->clientAddressProof->address_text;
                }
                $row['邮箱'] = $Client->email;
                $row['提交时间'] = date_format($Client->created_at, "Y-m-d H:i:s");
                $row['uuid'] = $Client->uuid;
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
