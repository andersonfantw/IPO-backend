<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientDepositProof;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RejectedList1Controller extends Controller
{
    protected $name = 'RejectedList1';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => 'AE', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '證件號碼', 'sortable' => true],
            ['key' => '已入金', 'sortable' => true],
            ['key' => '已退款', 'sortable' => true],
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
            '已退款' => 'equals',
            '手機號碼' => 'startsWith',
            '所在地' => 'equals',
            '郵箱' => 'startsWith',
            '提交時間' => 'betweenDate',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Clients = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
            ->whereHas('EditableSteps', function (Builder $query) {
                $query->where('reason', 'correction');
            })->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $total = $Clients->total();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $row['AE'] = $Client->ViewIntroducer->ae_name;
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['證件號碼'] = $Client->IDCard->idcard_no;
            $row['已入金'] = is_object($Client->ClientDepositProof) ? '是' : '否';
            $row['已退款'] = is_object($Client->ClientDepositProof) && $Client->ClientDepositProof->status == 'refunded' ? '是' : '否';
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
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $rows,
            'total' => $total,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function refund(Request $request)
    {
        $ClientDepositProof = ClientDepositProof::where('uuid', $request->input('uuid'))->update(['status' => 'refunded']);
        return ['success' => $ClientDepositProof > 0];
    }
}
