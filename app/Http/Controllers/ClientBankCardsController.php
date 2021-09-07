<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientBankCard;
use App\Traits\ImageLoader;
use Illuminate\Http\Request;

class ClientBankCardsController extends Controller
{
    use ImageLoader;

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
        $ClientBankCards = ClientBankCard::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->where('type', '拼一手')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientBankCards as $ClientBankCard) {
            $Client = $ClientBankCard->Client;
            if ($Client->status != 'audited2') {
                continue;
            }
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
