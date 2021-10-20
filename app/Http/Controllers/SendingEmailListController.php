<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Traits\Query;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class SendingEmailListController extends Controller
{
    use Query;

    protected $name = 'SendingEmailList';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => '操作'],
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '證件號碼', 'sortable' => true],
            ['key' => '電郵', 'sortable' => true],
            ['key' => '投遞日期', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '電郵發送者', 'sortable' => true],
            ['key' => '電郵發送時間', 'sortable' => true],
        ];
        $this->filter_type = [
            '帳戶號碼' => 'contains',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '電郵' => 'startsWith',
            '投遞日期' => 'betweenDate',
            '狀態' => 'equals',
            '電郵發送者' => 'startsWith',
            '電郵發送時間' => 'betweenDate',
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
        $證件號碼 = $request->input('證件號碼', null);
        $電郵 = $request->input('電郵', null);
        $投遞日期 = $request->input('投遞日期', null);
        $狀態 = $request->input('狀態', null);
        $電郵發送者 = $request->input('電郵發送者', null);
        $電郵發送時間 = $request->input('電郵發送時間', null);
        $Query = $this->getSendingEmailListQuery();
        if ($帳戶號碼) {
            $Query = $Query->whereHas('AyersAccounts', function (Builder $query) use ($帳戶號碼) {
                $query->where('account_no', 'like', "$帳戶號碼%");
            });
        }
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
        if ($電郵) {
            $Query = $Query->where('email', 'like', "$電郵%");
        }
        if (is_array($投遞日期) && count($投遞日期) == 2) {
            try {
                $投遞日期[0] = Carbon::parse($投遞日期[0])->addDays(1)->format('Y-m-d');
                $投遞日期[1] = Carbon::parse($投遞日期[1])->addDays(1)->format('Y-m-d');
                $Query = $Query->whereHas('AyersAccounts', function (Builder $query) use ($投遞日期) {
                    $query->whereBetween('updated_at', [$投遞日期[0], $投遞日期[1]]);
                });
            } catch (InvalidFormatException $e) {
            }
        }
        if ($狀態) {
            if ($狀態 == '已發送') {
                $狀態 = 'success';
            }
            $Query = $Query->whereHas('NotificationRecord', function (Builder $query) use ($狀態) {
                $query->where('status', $狀態)->where('title', '帳戶開戶通知書');
            });
        }
        if ($電郵發送者) {
            $Query = $Query->whereHas('NotificationRecord', function (Builder $query) use ($電郵發送者) {
                $query->where('issued_by', 'like', "$電郵發送者%")->where('title', '帳戶開戶通知書');
            });
        }
        if (is_array($電郵發送時間) && count($電郵發送時間) == 2) {
            try {
                $電郵發送時間[0] = Carbon::parse($電郵發送時間[0])->addDays(1)->format('Y-m-d');
                $電郵發送時間[1] = Carbon::parse($電郵發送時間[1])->addDays(1)->format('Y-m-d');
                $Query = $Query->whereHas('NotificationRecord', function (Builder $query) use ($電郵發送時間) {
                    $query->whereBetween('updated_at', [$電郵發送時間[0], $電郵發送時間[1]])
                        ->where('title', '帳戶開戶通知書');
                });
            } catch (InvalidFormatException $e) {
            }
        }
        $Clients = $Query->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $total = $Clients->total();
        $last_page = ceil($total / $request->input('perPage'));
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $AyersAccounts = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccounts[] = $AyersAccount->account_no;
                $row['投遞日期'] = date_format($AyersAccount->updated_at, "Y-m-d H:i:s");
            }
            $row['帳戶號碼'] = implode(", ", $AyersAccounts);
            $row['客户姓名'] = $Client->IDCard->name_c;
            $row['證件號碼'] = $Client->IDCard->idcard_no;
            // $row['手機號碼'] = $Client->mobile;
            $row['電郵'] = $Client->email;
            $NotificationRecord = $Client->NotificationRecord
                ->where('status', 'success')
                ->whereIn('title', ['帳戶開戶通知書', '帐户开户通知书'])
                ->orderBy('updated_at', 'desc')
                ->first();
            if (is_object($NotificationRecord)) {
                $row['狀態'] = '已發送';
                $row['電郵發送時間'] = date_format($NotificationRecord->updated_at, "Y-m-d H:i:s");
                $row['電郵發送者'] = $NotificationRecord->issued_by;
            } else {
                $row['狀態'] = '未發送';
                $row['電郵發送時間'] = null;
                $row['電郵發送者'] = null;
            }
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
}
