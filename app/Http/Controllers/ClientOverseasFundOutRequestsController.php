<?php

namespace App\Http\Controllers;

use App\ClientOverseasFundOutRequest;
use App\Traits\Excel;
use Illuminate\Http\Request;

class ClientOverseasFundOutRequestsController extends Controller
{
    use Excel;

    protected $name = 'ClientOverseasFundOutRequests';
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
        $this->filter_type = [
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
        $ClientOverseasFundOutRequests = ClientOverseasFundOutRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientOverseasFundOutRequests as $ClientOverseasFundOutRequest) {
            $Client = $ClientOverseasFundOutRequest->Client;
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['手機號碼'] = $Client->mobile;
            $row['狀態'] = $ClientOverseasFundOutRequest->status;
            $row['發送時間'] = date_format($ClientOverseasFundOutRequest->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientOverseasFundOutRequest->issued_by;
            $row['審批時間'] = $row['狀態'] == 'pending' ? null : date_format($ClientOverseasFundOutRequest->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientOverseasFundOutRequest->id;
            $rows[] = $row;
        }
        return json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function downloadAyersImportData(Request $request)
    {
        return $this->exportClientOverseasFundOutRequests();
    }
}
