<?php

namespace App\Http\Controllers;

use App\ClientCreditCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClientCreditCardsController extends Controller
{
    protected $name = 'ClientCreditCards';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '卡號', 'sortable' => true],
            ['key' => '發卡機構', 'sortable' => true],
            ['key' => '有效日期', 'sortable' => true],
            ['key' => '發送時間', 'sortable' => true],
            ['key' => '經手人', 'sortable' => true],
            ['key' => '審批時間', 'sortable' => true],
            ['key' => '操作'],
        ];
        $this->filter_type = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '手機號碼' => 'startsWith',
            '卡號' => 'startsWith',
            '發卡機構' => 'startsWith',
            '有效日期' => 'betweenDate',
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
        $ClientCreditCards = ClientCreditCard::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->whereHas('Client', function (Builder $query) {
                $query->where('status', 'audited2');
            })
            ->whereIn('status', ['pending', 'approved'])
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($ClientCreditCards as $ClientCreditCard) {
            $Client = $ClientCreditCard->Client;
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
            $row['卡號'] = $ClientCreditCard->card_no;
            $row['發卡機構'] = $ClientCreditCard->card_issuer;
            $row['有效日期'] = $ClientCreditCard->expiry_date;
            $row['發送時間'] = date_format($ClientCreditCard->created_at, "Y-m-d H:i:s");
            $row['經手人'] = $ClientCreditCard->issued_by;
            $row['狀態'] = $ClientCreditCard->status;
            $row['審批時間'] = $ClientCreditCard->status == 'pending' ? null : date_format($ClientCreditCard->updated_at, "Y-m-d H:i:s");
            $row['id'] = $ClientCreditCard->id;
            $rows[] = $row;
        }
        return json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }
}
