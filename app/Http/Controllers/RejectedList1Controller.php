<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientDepositProof;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Traits\Query;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class RejectedList1Controller extends Controller
{
    use Query;

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
        $客户姓名 = $request->input('客户姓名', null);
        $證件號碼 = $request->input('證件號碼', null);
        $手機號碼 = $request->input('手機號碼', null);
        $郵箱 = $request->input('郵箱', null);
        $提交時間 = $request->input('提交時間', null);
        $AE = $request->input('AE', null);
        $已入金 = $request->input('已入金', null);
        $已退款 = $request->input('已退款', null);
        $Query = $this->getRejectedList1Query();
        if ($客户姓名) {
            $Query = $Query->whereHasMorph('IDCard', ['App\ClientHKIDCard', 'App\ClientCNIDCard', 'App\ClientOtherIDCard'], function (Builder $query) use ($客户姓名) {
                $query->where('name_c', 'like', "$客户姓名%");
            });
        }
        if ($證件號碼) {
            $Query = $Query->whereHasMorph('IDCard', ['App\ClientHKIDCard', 'App\ClientCNIDCard', 'App\ClientOtherIDCard'], function (Builder $query) use ($證件號碼) {
                $query->where('idcard_no', 'like', "$證件號碼%");
            });
        }
        if ($手機號碼) {
            $Query = $Query->where('mobile', 'like', "$手機號碼%");
        }
        if ($郵箱) {
            $Query = $Query->where('email', 'like', "$郵箱%");
        }
        if (is_array($提交時間) && count($提交時間) == 2) {
            try {
                $提交時間[0] = Carbon::parse($提交時間[0])->addDays(1)->format('Y-m-d');
                $提交時間[1] = Carbon::parse($提交時間[1])->addDays(1)->format('Y-m-d');
                $Query = $Query->whereBetween('updated_at', [$提交時間[0], $提交時間[1]]);
            } catch (InvalidFormatException $e) {
            }
        }
        if ($AE) {
            $Query = $Query->whereHas('ViewIntroducer', function (Builder $query) use ($AE) {
                $query->where('ae_name', $AE);
            });
        }
        if ($已入金 == '是') {
            $Query = $Query->has('ClientDepositProof');
        } elseif ($已入金 == '否') {
            $Query = $Query->doesntHave('ClientDepositProof');
        }
        if ($已退款 == '是') {
            $Query = $Query->whereHas('ClientDepositProof', function (Builder $query) {
                $query->where('status', 'refunded');
            });
        } elseif ($已退款 == '否') {
            $Query = $Query->whereHas('ClientDepositProof', function (Builder $query) {
                $query->where('status', '!=', 'refunded');
            });
        }
        $Clients = $Query->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $total = $Clients->total();
        $last_page = ceil($total / $request->input('perPage'));
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
            'last_page' => $last_page
        ], JSON_UNESCAPED_UNICODE);
    }

    public function refund(Request $request)
    {
        $ClientDepositProof = ClientDepositProof::where('uuid', $request->input('uuid'))->update(['status' => 'refunded']);
        return ['success' => $ClientDepositProof > 0];
    }
}
