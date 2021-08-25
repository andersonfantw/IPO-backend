<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientHKFundOutRequest;
use App\Traits\Excel;
use Illuminate\Http\Request;

class ClientHKFundOutRequestsController extends Controller
{
    use Excel;

    protected $name = 'ClientHKFundOutRequests';
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
            // ['key' => '銀行帳戶', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '發送時間', 'sortable' => true],
            ['key' => '經手人', 'sortable' => true],
            ['key' => '審批時間', 'sortable' => true],
            ['key' => '操作'],
        ];
        $this->FilterType = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '銀行' => 'equals',
            '金額' => 'equals',
            // '銀行帳戶' => 'startsWith',
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
        // $yesterday = today()->subDays(3)->toDateString();
        $ClientHKFundOutRequests = ClientHKFundOutRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientHKFundOutRequests as $ClientHKFundOutRequest) {
            $Client = $ClientHKFundOutRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['銀行'] = $ClientHKFundOutRequest->bank;
            // $row['銀行帳戶'] = $ClientHKFundOutRequest->account_in;
            $row['金額'] = number_format($ClientHKFundOutRequest->amount, 2, '.', '');
            $row['狀態'] = $ClientHKFundOutRequest->status;
            $row['發送時間'] = date_format($ClientHKFundOutRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientHKFundOutRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientHKFundOutRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientHKFundOutRequest->id;
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
        $ClientHKFundOutRequest1 = ClientHKFundOutRequest::find($id);
        $ClientHKFundOutRequest2 = clone $ClientHKFundOutRequest1;
        $Client = clone $ClientHKFundOutRequest1->Client;
        $AyersAccounts = $ClientHKFundOutRequest1->Client->AyersAccounts;
        $IDCard = $ClientHKFundOutRequest1->Client->IDCard;
    }

    public function downloadAyersImportData(Request $request)
    {
        return $this->exportClientHKFundOutRequests();
    }

    public function downloadAyersImportData2(Request $request)
    {
        return $this->exportClientHKFundOutRequests2();
    }
}
