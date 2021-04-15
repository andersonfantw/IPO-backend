<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReauditList1Controller extends HomeController
{
    protected $name = 'ReauditList1';
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
            '是否已有账户' => 'equals',
            // '是否上传收据' => 'equals',
            '證件號碼' => 'startsWith', '手機號碼' => 'startsWith',
            '所在地' => 'equals', '郵箱' => 'equals',
            '认领时间' => 'equals', '提交時間' => 'equals'];
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
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientAddressProof', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhere('status', 'reaudit')->orderBy('created_at', 'desc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            foreach ($this->columnNames as $columnKey => $columnName) {
                // $row['是否上传收据'] = $Client->ClientDepositProof ? '已上传收据' : '未上传收据';
                if ($Client->idcard_type == ClientHKIDCard::class) {
                    $row['客户姓名'] = $Client->IDCard->name_c;
                    $row['證件號碼'] = $Client->IDCard->idcard_no;
                } elseif ($Client->idcard_type == ClientCNIDCard::class) {
                    $row['客户姓名'] = $Client->IDCard->name_c;
                    $row['證件號碼'] = $Client->IDCard->idcard_no;
                    $row['所在地'] = $Client->IDCard->idcard_address;
                }
                $row['手機號碼'] = $Client->mobile;
                if ($Client->ClientAddressProof) {
                    $row['所在地'] = $Client->ClientAddressProof->address_text;
                }
                $row['郵箱'] = $Client->email;
                $row['提交時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
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
