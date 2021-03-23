<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DeliverableList2Controller extends HomeController
{
    protected $name = 'DeliverableList2';
    private $columnNames;

    public function __construct()
    {
        parent::__construct();
        $this->columnNames = [
            'account_type' => '开通账户类型',
            'idCard' => '证件号码',
            'mobile' => '手机号码',
            'email' => '邮箱',
            'lastTime' => '开户时间',
            'created_at' => '賬戶生成时间',
            'relation' => '客户姓名',
            'uuid' => '唯一编码',
            'ayers_account_no' => 'Ayers帳戶號碼',
        ];
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['field' => 'Ayers帳戶號碼', 'header' => 'Ayers帳戶號碼'],
            ['field' => '开通账户类型', 'header' => '开通账户类型'],
            ['field' => '客户姓名', 'header' => '客户姓名'],
            ['field' => '证件号码', 'header' => '证件号码'],
            ['field' => '手机号码', 'header' => '手机号码'],
            ['field' => '邮箱', 'header' => '邮箱'],
            ['field' => '开户时间', 'header' => '开户时间'],
            ['field' => '賬戶生成时间', 'header' => '賬戶生成时间'],
        ];
        $filterMatchMode = [
            'Ayers帳戶號碼' => 'startsWith',
            '开通账户类型' => 'equals',
            '客户姓名' => 'startsWith',
            '证件号码' => 'startsWith', '手机号码' => 'startsWith',
            '邮箱' => 'equals',
            '开户时间' => 'equals',
            '賬戶生成时间' => 'equals',
        ];
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
            $query->where('status', 'audited2');
        })->whereHas('clientBankCard', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('clientWorkingStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('clientFinancialStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('clientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('clientEvaluationResults', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('clientSignature', function (Builder $query) {
            $query->where('status', 'audited2');
        })->where('status', 'audited2')->orderBy('created_at', 'desc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            if ($Client->AyersAccounts->isNotEmpty()) {
                foreach ($Client->AyersAccounts as $AyersAccount) {
                    $row = [];
                    foreach ($this->columnNames as $columnKey => $columnName) {
                        $row['Ayers帳戶號碼'] = $AyersAccount->account_no;
                        $row['开通账户类型'] = $AyersAccount->type;
                        if ($Client->idcard_type == ClientHKIDCard::class) {
                            $row['客户姓名'] = $Client->IDCard->name_tc;
                            $row['证件号码'] = $Client->IDCard->idcard_no;
                        } elseif ($Client->idcard_type == ClientCNIDCard::class) {
                            $row['客户姓名'] = $Client->IDCard->name_sc;
                            $row['证件号码'] = $Client->IDCard->idcard_no;
                        }
                        $row['手机号码'] = $Client->mobile;
                        $row['邮箱'] = $Client->email;
                        $row['开户时间'] = date_format($Client->created_at, "Y-m-d H:i:s");
                        $row['賬戶生成时间'] = date_format($AyersAccount->created_at, "Y-m-d H:i:s");
                        $row['uuid'] = $Client->uuid;
                    }
                    $rows[] = $row;
                }
            } else {
                $row = [];
                foreach ($this->columnNames as $columnKey => $columnName) {
                    $row['Ayers帳戶號碼'] = null;
                    $row['开通账户类型'] = null;
                    if ($Client->idcard_type == ClientHKIDCard::class) {
                        $row['客户姓名'] = $Client->IDCard->name_tc;
                        $row['证件号码'] = $Client->IDCard->idcard_no;
                    } elseif ($Client->idcard_type == ClientCNIDCard::class) {
                        $row['客户姓名'] = $Client->IDCard->name_sc;
                        $row['证件号码'] = $Client->IDCard->idcard_no;
                    }
                    $row['手机号码'] = $Client->mobile;
                    $row['邮箱'] = $Client->email;
                    $row['开户时间'] = date_format($Client->created_at, "Y-m-d H:i:s");
                    $row['賬戶生成时间'] = null;
                    $row['uuid'] = $Client->uuid;
                }
                $rows[] = $row;
            }
        }
        return encrypt(json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE));
        // return json_encode([
        //     'data' => $rs,
        // ], JSON_UNESCAPED_UNICODE);
    }
}
