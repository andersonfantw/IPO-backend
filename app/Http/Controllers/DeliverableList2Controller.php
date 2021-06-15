<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\Traits\Excel;
use App\ViewClientIDCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DeliverableList2Controller extends HomeController
{

    use Excel;

    protected $name = 'DeliverableList2';

    public function __construct()
    {
        parent::__construct();
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
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
        $FilterType = [
            '帳戶號碼' => 'startsWith',
            '開通賬戶類型' => 'equals',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '手機號碼' => 'startsWith',
            '郵箱' => 'startsWith',
            '開戶時間' => 'between',
            '帳戶生成時間' => 'between',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        return $parameters;
    }

    public function getData(Request $request)
    {
        $Clients = Client::whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'audited2');
        })->where('status', 'audited2')->orderBy('created_at', 'asc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            if ($Client->AyersAccounts->isNotEmpty()) {
                foreach ($Client->AyersAccounts as $AyersAccount) {
                    $row = [];
                    $row['帳戶號碼'] = $AyersAccount->account_no;
                    $row['開通賬戶類型'] = $AyersAccount->type;
                    $row['客户姓名'] = $Client->IDCard->name_c;
                    $row['證件號碼'] = $Client->IDCard->idcard_no;
                    $row['手機號碼'] = $Client->mobile;
                    $row['郵箱'] = $Client->email;
                    $row['開戶時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
                    $row['帳戶生成時間'] = date_format($AyersAccount->created_at, "Y-m-d H:i:s");
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
                $row['開戶時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
                $row['帳戶生成時間'] = null;
                $row['uuid'] = $Client->uuid;
                $rows[] = $row;
            }
        }
        return encrypt(json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE));
        // return json_encode([
        //     'data' => $rs,
        // ], JSON_UNESCAPED_UNICODE);
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
            $ClientIDCard = ViewClientIDCard::where('uuid', $client['uuid'])->first();
            $idcard_face = $this->saveBase64Image($this->blobToBase64($ClientIDCard->idcard_face), "upload/$ClientIDCard->uuid", 'idcard_face');
            $idcard_back = $this->saveBase64Image($this->blobToBase64($ClientIDCard->idcard_back), "upload/$ClientIDCard->uuid", 'idcard_back');
            $zipFile->addDir(storage_path("app/upload/$ClientIDCard->uuid"));
        }
        $zipFile->saveAsFile(storage_path("app/public/file.zip"))->close();
        return response()->download(storage_path("app/public/file.zip"));
    }
}
