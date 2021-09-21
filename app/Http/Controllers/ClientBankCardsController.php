<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientBankCard;
use App\Traits\ImageLoader;
use Illuminate\Http\Request;
use App\Traits\Query;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class ClientBankCardsController extends Controller
{
    use ImageLoader, Query;

    protected $name = 'ClientBankCards';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '地區', 'sortable' => true],
            ['key' => '銀行', 'sortable' => true],
            ['key' => '銀行戶口', 'sortable' => true],
            ['key' => '發送時間', 'sortable' => true],
            ['key' => '經手人', 'sortable' => true],
            ['key' => '審批時間', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '操作'],
        ];
        $this->filter_type = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '地區' => 'equals',
            '銀行' => 'startsWith',
            '銀行戶口' => 'equals',
            '發送時間' => 'betweenDate',
            '經手人' => 'startsWith',
            '審批時間' => 'betweenDate',
            '狀態' => 'equals',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $帳戶號碼 = $request->input('帳戶號碼', null);
        $客户姓名 = $request->input('客户姓名', null);
        $手機號碼 = $request->input('手機號碼', null);
        $狀態 = $request->input('狀態', null);
        $發送時間 = $request->input('發送時間', null);
        $審批時間 = $request->input('審批時間', null);
        $Query = $this->getClientBankCardsQuery();
        if ($帳戶號碼) {
            $Query = $Query->whereHas('Client.AyersAccounts', function (Builder $query) use ($帳戶號碼) {
                $query->where('account_no', 'like', "$帳戶號碼%");
            });
        }
        if ($客户姓名) {
            $Query = $Query->whereHas('Client', function (Builder $query) use ($客户姓名) {
                $query->whereHasMorph('IDCard', ['App\ClientHKIDCard', 'App\ClientCNIDCard', 'App\ClientOtherIDCard'], function (Builder $query) use ($客户姓名) {
                    $query->where('name_c', 'like', "$客户姓名%");
                });
            });
        }
        if ($手機號碼) {
            $Query = $Query->whereHas('Client', function (Builder $query) use ($手機號碼) {
                $query->where('mobile', 'like', "$手機號碼%");
            });
        }
        if ($狀態) {
            $Query = $Query->where('status', $狀態);
        }
        if (is_array($發送時間) && count($發送時間) == 2) {
            try {
                $發送時間[0] = Carbon::parse($發送時間[0])->addDays(1)->format('Y-m-d');
                $發送時間[1] = Carbon::parse($發送時間[1])->addDays(1)->format('Y-m-d');
                $Query = $Query->whereBetween('created_at', [$發送時間[0], $發送時間[1]]);
            } catch (InvalidFormatException $e) {
            }
        }
        if (is_array($審批時間) && count($審批時間) == 2) {
            try {
                $審批時間[0] = Carbon::parse($審批時間[0])->addDays(1)->format('Y-m-d');
                $審批時間[1] = Carbon::parse($審批時間[1])->addDays(1)->format('Y-m-d');
                $Query = $Query->whereBetween('updated_at', [$審批時間[0], $審批時間[1]]);
            } catch (InvalidFormatException $e) {
            }
        }
        $ClientBankCards = $Query->whereIn('status', ['approved', 'pending', 'rejected'])
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $total = $ClientBankCards->total();
        $last_page = $ClientBankCards->lastPage();
        $rows = [];
        foreach ($ClientBankCards as $ClientBankCard) {
            $Client = $ClientBankCard->Client;
            // if ($Client->status != 'audited2') {
            //     continue;
            // }
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['地區'] = $ClientBankCard->lcid;
            $row['銀行'] = $ClientBankCard->bank_name;
            $row['銀行戶口'] = $ClientBankCard->account_no;
            $row['發送時間'] = date_format($ClientBankCard->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientBankCard->issued_by;
            $row['狀態'] = $ClientBankCard->status;
            $row['審批時間'] = $ClientBankCard->status == 'pending' ? null : date_format($ClientBankCard->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientBankCard->id;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ClientBankCard1 = ClientBankCard::find($id);
        $ClientBankCard2 = clone $ClientBankCard1;
        $ClientBankCard2->backcard_face = null;
        $ClientBankCard2->bankcard_blob = null;
        $Client = clone $ClientBankCard1->Client;
        $IDCard = $ClientBankCard1->Client->IDCard;
        $IDCard->idcard_face = null;
        $IDCard->idcard_back = null;
        return json_encode([
            'ClientBankCard' => $ClientBankCard2,
            'Client' => $Client,
            'IDCard' => $IDCard,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has(['駁回信息']) && $request->filled(['駁回信息'])) {
            ClientBankCard::find($id)->update([
                'status' => 'rejected',
                'issued_by' => auth()->user()->name,
                'remark' => $request->input('駁回信息'),
            ]);
        } else {
            ClientBankCard::find($id)->update([
                'status' => 'approved',
                'issued_by' => auth()->user()->name,
                'remark' => null,
            ]);
        }
    }
}
