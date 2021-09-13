<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\Traits\CountRecords;
use App\Traits\Report;
use App\Traits\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UnauditedList1Controller extends Controller
{
    use Report, CountRecords, Query;

    protected $name = 'UnauditedList1';
    private $fields = null;
    private $filter_type = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fields = [
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
        $this->filter_type = [
            'AE' => 'equals',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '已入金' => 'equals',
            '手機號碼' => 'startsWith',
            '所在地' => 'equals',
            '郵箱' => 'startsWith',
            '提交時間' => 'betweenDate',
        ];
    }

    // protected function setViewParameters(Request $request)
    // {
    //     $parameters = parent::setViewParameters($request);
    //     $parameters['fields'] = json_encode($fields);
    //     $parameters['filter_type'] = json_encode($filter_type);
    //     return $parameters;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Clients = $this->getUnauditedList1Query()
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        // $Clients = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
        //     ->has('ClientBusinessType')->whereHasMorph('IDCard', [
        //         ClientCNIDCard::class,
        //         ClientHKIDCard::class,
        //         ClientOtherIDCard::class,
        //     ], function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->whereHas('ClientWorkingStatus', function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->whereHas('ClientFinancialStatus', function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->whereHas('ClientInvestmentExperience', function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->whereHas('ClientEvaluationResults', function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->whereHas('ClientSignature', function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->whereHas('ClientDepositProof', function (Builder $query) {
        //         $query->where('status', 'unaudited');
        //     })->where('status', 'unaudited')
        //     ->orWhere(function (Builder $query) {
        //         $query->where('status', 'unaudited')
        //             ->where('progress', 16)
        //             ->where('idcard_type', 'App\ClientOtherIDCard')
        //             ->whereHas('ClientAddressProof', function (Builder $query) {
        //                 $query->where('status', 'unaudited');
        //             });
        //     })
        //     ->orderBy('updated_at', 'desc')
        //     ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
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
            $row['id'] = $Client->id;
            $rows[] = $row;
        }
        return json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }
}
