<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\Traits\Excel;
use App\Traits\Image;
use App\Traits\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class DeliverableList2Controller extends Controller
{

    use Excel, Image, Query;

    protected $name = 'DeliverableList2';
    private $fields = null;
    private $filter_type = null;

    public function __construct()
    {
        $this->fields = [
            ['key' => '操作'],
            ['key' => '帳戶號碼', 'sortable' => true],
            ['key' => '開通賬戶類型', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '證件號碼', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '郵箱', 'sortable' => true],
            ['key' => '開戶時間', 'sortable' => true],
            ['key' => '帳戶生成時間', 'sortable' => true],
        ];
        $this->filter_type = [
            '帳戶號碼' => 'startsWith',
            '開通賬戶類型' => 'equals',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '手機號碼' => 'startsWith',
            '郵箱' => 'startsWith',
            '開戶時間' => 'betweenDate',
            '帳戶生成時間' => 'betweenDate',
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
        $開通賬戶類型 = $request->input('開通賬戶類型', null);
        $客户姓名 = $request->input('客户姓名', null);
        $證件號碼 = $request->input('證件號碼', null);
        $手機號碼 = $request->input('手機號碼', null);
        $郵箱 = $request->input('郵箱', null);
        $開戶時間 = $request->input('開戶時間', null);
        $帳戶生成時間 = $request->input('帳戶生成時間', null);
        $Query = $this->getDeliverableList2Query();
        if ($帳戶號碼) {
            $Query = $Query->whereHas('AyersAccounts', function (Builder $query) use ($帳戶號碼) {
                $query->where('account_no', 'like', "$帳戶號碼%");
            });
        }
        if ($開通賬戶類型) {
            $Query = $Query->whereHas('AyersAccounts', function (Builder $query) use ($開通賬戶類型) {
                $query->where('type', $開通賬戶類型);
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
        if ($手機號碼) {
            $Query = $Query->where('mobile', 'like', "$手機號碼%");
        }
        if ($郵箱) {
            $Query = $Query->where('email', 'like', "$郵箱%");
        }
        if (is_array($開戶時間) && count($開戶時間) == 2) {
            try {
                $開戶時間[0] = Carbon::parse($開戶時間[0])->addDays(1)->format('Y-m-d');
                $開戶時間[1] = Carbon::parse($開戶時間[1])->addDays(1)->format('Y-m-d');
                $Query = $Query->whereBetween('updated_at', [$開戶時間[0], $開戶時間[1]]);
            } catch (InvalidFormatException $e) {
            }
        }
        if (is_array($帳戶生成時間) && count($帳戶生成時間) == 2) {
            try {
                $帳戶生成時間[0] = Carbon::parse($帳戶生成時間[0])->addDays(1)->format('Y-m-d H:i:s');
                $帳戶生成時間[1] = Carbon::parse($帳戶生成時間[1])->addDays(1)->format('Y-m-d H:i:s');
                $Query = $Query->whereHas('AyersAccounts', function (Builder $query) use ($帳戶生成時間) {
                    $query->whereBetween('updated_at', [$帳戶生成時間[0], $帳戶生成時間[1]]);
                });
            } catch (InvalidFormatException $e) {
            }
        }
        $Clients = $Query
            ->orWhere(function (Builder $query) {
                $query->where('status', 'audited2')
                    ->where('progress', 16)
                    ->where('idcard_type', 'App\ClientOtherIDCard');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $total = $Clients->total();
        $last_page = ceil($total / $request->input('perPage'));
        $rows = [];
        foreach ($Clients as $Client) {
            if (count($Client->AyersAccounts) > 0) {
                foreach ($Client->AyersAccounts as $AyersAccount) {
                    $row = [];
                    $row['帳戶號碼'] = $AyersAccount->account_no;
                    $row['開通賬戶類型'] = $AyersAccount->type;
                    $row['客户姓名'] = $Client->IDCard->name_c;
                    $row['證件號碼'] = $Client->IDCard->idcard_no;
                    $row['手機號碼'] = $Client->mobile;
                    $row['郵箱'] = $Client->email;
                    $row['開戶時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
                    $row['帳戶生成時間'] = $AyersAccount->created_at ? date_format($AyersAccount->created_at, "Y-m-d H:i:s") : $AyersAccount->created_at;
                    $row['uuid'] = $Client->uuid;
                    $rows[] = $row;
                }
            } else {
                $row = [];
                $row['帳戶號碼'] = null;
                $row['開通賬戶類型'] = null;
                $row['客户姓名'] = $Client->IDCard->name_c;
                $row['證件號碼'] = $Client->IDCard->idcard_no;
                $row['手機號碼'] = $Client->mobile;
                $row['郵箱'] = $Client->email;
                $row['開戶時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
                $row['帳戶生成時間'] = null;
                $row['uuid'] = $Client->uuid;
                $rows[] = $row;
            }
        }
        return json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $rows,
            'total' => $total,
            'last_page' => $last_page
        ], JSON_UNESCAPED_UNICODE);
    }

    public function downloadAyersImportData(Request $request)
    {
        $clients = $request->input('clients');
        return $this->exportAyersImportData($clients);
    }

    public function downloadFilesForOpeningAccount(Request $request)
    {
        $zipFile = new \PhpZip\ZipFile();
        $clients = $request->input('clients');
        foreach ($clients as $client) {
            $Client = Client::where('uuid', $client['uuid'])->first();
            $ClientIDCard = $Client->IDCard;
            $idcard_face = $this->saveBase64Image($this->blobToBase64($ClientIDCard->idcard_face), "upload/$ClientIDCard->uuid", 'idcard_face');
            $idcard_back = $this->saveBase64Image($this->blobToBase64($ClientIDCard->idcard_back), "upload/$ClientIDCard->uuid", 'idcard_back');
            $zipFile->addDir(storage_path("app/upload/$ClientIDCard->uuid"));
        }
        $zipFile->saveAsFile(storage_path("app/public/file.zip"))->close();
        return response()->download(storage_path("app/public/file.zip"));
    }
}
