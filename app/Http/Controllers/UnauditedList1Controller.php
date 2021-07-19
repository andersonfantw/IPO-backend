<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\Traits\CountRecords;
use App\Traits\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UnauditedList1Controller extends HomeController
{
    use Report, CountRecords;

    protected $name = 'UnauditedList1';

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
            ->has('ClientBusinessType')->whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
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
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->where('status', 'unaudited')->orderBy('created_at', 'asc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        // $Clients = Client::whereHas('ClientSignature', function (Builder $query) {
        //     $query->where('status', 'unaudited');
        // })->where('status', 'unaudited')
        //     ->where('idcard_type', '!=', 'App\ClientOtherIDCard')
        //     ->orderBy('created_at', 'asc')
        //     ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));

        // $Clients = ViewPendingClient::where(function ($query) {
        //     $query->where('has_deposit_proof', 1)
        //         ->where('deposit_proof_status', 'unaudited')
        //         ->orWhere(function ($query) {
        //             $query->where('nationality', 'others')
        //                 ->where('progress', 16);
        //         });
        // })
        //     ->where('status', 'unaudited')
        //     ->select('ae_name as AE',
        //         'name_c as 客户姓名',
        //         'idcard_no as 證件號碼',
        //         DB::raw('case when has_deposit_proof=0 then "否" else "是" end as 已入金'),
        //         'address as 所在地',
        //         'mobile as 手機號碼',
        //         'email as 郵箱',
        //         'updated_at as 提交時間',
        //         'uuid')
        //     ->orderBy('updated_at', 'asc')
        //     ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        // return $Clients;

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
            $row['提交時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $rows[] = $row;
        }

        // $Clients = Client::where('status', 'unaudited')->where('progress', 16)->
        //     where('idcard_type', 'App\ClientOtherIDCard')->orderBy('created_at', 'asc')->get();
        // foreach ($Clients as $Client) {
        //     $row = [];
        //     $row['AE'] = $Client->ViewIntroducer->ae_name;
        //     $row['客户姓名'] = $Client->IDCard->name_c;
        //     $row['證件號碼'] = $Client->IDCard->idcard_no;
        //     $row['已入金'] = is_object($Client->ClientDepositProof) ? '是' : '否';
        //     if (is_object($Client->ClientAddressProof)) {
        //         $row['所在地'] = $Client->ClientAddressProof->address_text;
        //     } else {
        //         $row['所在地'] = $Client->IDCard->idcard_address;
        //     }
        //     $row['手機號碼'] = $Client->mobile;
        //     $row['郵箱'] = $Client->email;
        //     $row['提交時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
        //     $row['uuid'] = $Client->uuid;
        //     $rows[] = $row;
        // }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
        // return json_encode([
        //     'data' => $rs,
        // ], JSON_UNESCAPED_UNICODE);
    }
}
