<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UnauditedList2Controller extends HomeController
{
    protected $name = 'UnauditedList2';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['key' => 'AE', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '證件號碼', 'sortable' => true],
            ['key' => '已入金', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '所在地', 'sortable' => true],
            ['key' => '郵箱', 'sortable' => true],
            ['key' => '提交時間', 'sortable' => true],
            ['key' => '操作'],
        ];
        $FilterType = [
            'AE' => 'equals',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '已入金' => 'equals',
            '手機號碼' => 'startsWith',
            '所在地' => 'equals',
            '郵箱' => 'startsWith',
            '提交時間' => 'betweenDate',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
            ->whereHasMorph('IDCard', [
                ClientCNIDCard::class,
                ClientHKIDCard::class,
                ClientOtherIDCard::class,
            ], function (Builder $query) {
                $query->where('status', 'audited1');
            })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'audited1');
        })->where('status', 'audited1')
            ->orWhere(function (Builder $query) {
                $query->where('status', 'audited1')
                    ->where('progress', 16)
                    ->where('idcard_type', 'App\ClientOtherIDCard');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $row['AE'] = $Client->ViewIntroducer->ae_name;
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['證件號碼'] = $Client->IDCard->idcard_no;
            $row['已入金'] = is_object($Client->ClientDepositProof) ? '是' : '否';
            if (is_object($Client->ClientAddressProof)) {
                $row['所在地'] = $Client->ClientAddressProof->address_text;
            } else {
                $row['所在地'] = $Client->IDCard->idcard_address;
            }
            $row['手機號碼'] = $Client->mobile;
            $row['郵箱'] = $Client->email;
            $row['提交時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $rows[] = $row;
        }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }
}
