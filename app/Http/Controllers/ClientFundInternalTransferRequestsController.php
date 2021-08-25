<?php

namespace App\Http\Controllers;

use App\ClientFundInternalTransferRequest;
use App\Traits\Excel;
use Illuminate\Http\Request;

class ClientFundInternalTransferRequestsController extends Controller
{
    use Excel;

    protected $name = 'ClientFundInternalTransferRequests';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
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
        $ClientFundInternalTransferRequests = ClientFundInternalTransferRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->orderBy('updated_at', 'desc')->get();
        $rows = [];
        foreach ($ClientFundInternalTransferRequests as $ClientFundInternalTransferRequest) {
            $Client = $ClientFundInternalTransferRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['銀行'] = $ClientFundInternalTransferRequest->bank;
            $row['方法'] = $ClientFundInternalTransferRequest->method;
            $row['狀態'] = $ClientFundInternalTransferRequest->status;
            $row['發送時間'] = date_format($ClientFundInternalTransferRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientFundInternalTransferRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientFundInternalTransferRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientFundInternalTransferRequest->id;
            $rows[] = $row;
        }
        return encrypt(json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE));
        // return json_encode([
        //     'data' => $rows,
        // ], JSON_UNESCAPED_UNICODE);
    }

    public function downloadClientFundInternalTransferFundOutRequests(Request $request)
    {
        return $this->exportClientFundInternalTransferFundOutRequests();
    }

    public function downloadClientFundInternalTransferFundInRequests(Request $request)
    {
        return $this->exportClientFundInternalTransferFundInRequests();
    }
}
