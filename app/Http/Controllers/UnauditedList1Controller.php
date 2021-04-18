<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\Traits\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UnauditedList1Controller extends HomeController
{
    use Report;

    protected $name = 'UnauditedList1';
    private $columnNames;

    public function __construct()
    {
        parent::__construct();
        $this->columnNames = [
            'idCard' => '證件號碼',
            'mobile' => '手機號碼',
            'residenceAddr' => '所在地',
            'email' => '郵箱',
            'lastTime' => '提交時間',
            'relation' => '客户姓名',
            'uuid' => '唯一编码',
        ];
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['field' => '客户姓名', 'header' => '客户姓名'],
            ['field' => '證件號碼', 'header' => '證件號碼'],
            ['field' => '手機號碼', 'header' => '手機號碼'],
            ['field' => '所在地', 'header' => '所在地'],
            ['field' => '郵箱', 'header' => '郵箱'],
            ['field' => '提交時間', 'header' => '提交時間'],
        ];
        $filterMatchMode = [
            '客户姓名' => 'startsWith',
            '是否已有账户' => 'equals',
            '證件號碼' => 'startsWith', '手機號碼' => 'startsWith',
            '所在地' => 'equals', '郵箱' => 'equals',
            '认领时间' => 'equals', '提交時間' => 'equals'];
        $parameters['columns'] = json_encode($columns);
        $parameters['filterMatchMode'] = json_encode($filterMatchMode);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::has('ClientBusinessType')->whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->orWhereHas('ClientAddressProof', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->where('status', 'unaudited')->orderBy('created_at', 'desc')->get();
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
