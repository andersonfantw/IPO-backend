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
            'account_type' => '開通賬戶類型',
            'idCard' => '證件號碼',
            'mobile' => '手機號碼',
            'email' => '郵箱',
            'lastTime' => '開戶時間',
            'created_at' => '帳戶生成時間',
            'relation' => '客户姓名',
            'uuid' => '唯一编码',
            'ayers_account_no' => '帳戶號碼',
        ];
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['field' => '帳戶號碼', 'header' => '帳戶號碼'],
            ['field' => '開通賬戶類型', 'header' => '開通賬戶類型'],
            ['field' => '客户姓名', 'header' => '客户姓名'],
            ['field' => '證件號碼', 'header' => '證件號碼'],
            ['field' => '手機號碼', 'header' => '手機號碼'],
            ['field' => '郵箱', 'header' => '郵箱'],
            ['field' => '開戶時間', 'header' => '開戶時間'],
            ['field' => '帳戶生成時間', 'header' => '帳戶生成時間'],
        ];
        $filterMatchMode = [
            '帳戶號碼' => 'startsWith',
            '開通賬戶類型' => 'equals',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '手機號碼' => 'startsWith',
            '郵箱' => 'startsWith',
            '開戶時間' => 'equals',
            '帳戶生成時間' => 'equals',
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
        })->whereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'audited2');
        })->orWhereHas('ClientAddressProof', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'audited2');
        })->where('status', 'audited2')->orderBy('created_at', 'asc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            if ($Client->AyersAccounts->isNotEmpty()) {
                foreach ($Client->AyersAccounts as $AyersAccount) {
                    $row = [];
                    $row['帳戶號碼'] = $AyersAccount->account_no;
                    $row['開通賬戶類型'] = $AyersAccount->type;
                    if ($Client->idcard_type == ClientHKIDCard::class) {
                        $row['客户姓名'] = $Client->IDCard->name_c;
                        $row['證件號碼'] = $Client->IDCard->idcard_no;
                    } elseif ($Client->idcard_type == ClientCNIDCard::class) {
                        $row['客户姓名'] = $Client->IDCard->name_c;
                        $row['證件號碼'] = $Client->IDCard->idcard_no;
                    }
                    $row['手機號碼'] = $Client->mobile;
                    $row['郵箱'] = $Client->email;
                    $row['開戶時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
                    $row['帳戶生成時間'] = date_format($AyersAccount->created_at, "Y-m-d H:i:s");
                    $row['uuid'] = $Client->uuid;
                    $rows[] = $row;
                }
            } else {
                $row = [];
                $row['帳戶號碼'] = null;
                $row['開通賬戶類型'] = null;
                if ($Client->idcard_type == ClientHKIDCard::class) {
                    $row['客户姓名'] = $Client->IDCard->name_c;
                    $row['證件號碼'] = $Client->IDCard->idcard_no;
                } elseif ($Client->idcard_type == ClientCNIDCard::class) {
                    $row['客户姓名'] = $Client->IDCard->name_c;
                    $row['證件號碼'] = $Client->IDCard->idcard_no;
                }
                $row['手機號碼'] = $Client->mobile;
                $row['郵箱'] = $Client->email;
                $row['開戶時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
                $row['帳戶生成時間'] = null;
                $row['uuid'] = $Client->uuid;
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
