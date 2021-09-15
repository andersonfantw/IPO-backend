<?php

namespace App\Http\Controllers;

use App\ClientFundInRequest;
use App\Traits\Excel;
use Illuminate\Http\Request;
use App\Traits\Query;

class ClientFundInRequestsController extends Controller
{
    use Excel, Query;

    protected $name = 'ClientFundInRequests';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '銀行', 'sortable' => true],
            ['key' => '金額', 'sortable' => true],
            ['key' => '方法', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '發送時間', 'sortable' => true],
            ['key' => '經手人', 'sortable' => true],
            ['key' => '審批時間', 'sortable' => true],
            ['key' => '操作'],
        ];
        $this->filter_type = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '銀行' => 'equals',
            '金額' => 'equals',
            '方法' => 'equals',
            '狀態' => 'equals',
            '發送時間' => 'betweenDate',
            '經手人' => 'startsWith',
            '審批時間' => 'betweenDate',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ClientFundInRequests = $this->getClientFundInRequestsQuery()
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        // $ClientFundInRequests = ClientFundInRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
        //     ->orderBy('updated_at', 'desc')
        //     ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientFundInRequests as $ClientFundInRequest) {
            $Client = $ClientFundInRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['銀行'] = $ClientFundInRequest->bank;
            $row['方法'] = $ClientFundInRequest->method;
            $row['金額'] = $ClientFundInRequest->amount;
            $row['狀態'] = $ClientFundInRequest->status;
            $row['發送時間'] = date_format($ClientFundInRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientFundInRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientFundInRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientFundInRequest->id;
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
        $ClientFundInRequest1 = ClientFundInRequest::find($id);
        $ClientFundInRequest2 = clone $ClientFundInRequest1;
        $ClientFundInRequest2->receipt = null;
        $ClientFundInRequest2->bankcard = null;
        $Client = clone $ClientFundInRequest1->Client;
        $AyersAccounts = $ClientFundInRequest1->Client->AyersAccounts;
        $IDCard = $ClientFundInRequest1->Client->IDCard;
        $IDCard->idcard_face = null;
        $IDCard->idcard_back = null;
        return json_encode([
            'Request' => $ClientFundInRequest2,
            'Client' => $Client,
            'AyersAccounts' => $AyersAccounts,
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
            ClientFundInRequest::find($id)->update([
                'status' => 'rejected',
                'issued_by' => auth()->user()->name,
                'remark' => $request->input('駁回信息'),
            ]);
        } else {
            ClientFundInRequest::find($id)->update([
                'status' => 'approved',
                'issued_by' => auth()->user()->name,
                'remark' => null,
            ]);
        }
    }

    public function downloadAyersImportData(Request $request)
    {
        return $this->exportClientFundInRequests();
    }

    public function downloadAyersImportData2(Request $request)
    {
    }
}
