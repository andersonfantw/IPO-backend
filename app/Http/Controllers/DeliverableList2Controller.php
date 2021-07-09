<?php

namespace App\Http\Controllers;

use App\Client;
use App\Traits\Excel;
use App\ViewDeliverableClient;
use Illuminate\Http\Request;

class DeliverableList2Controller extends HomeController
{

    use Excel;

    protected $name = 'DeliverableList2';

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
            '開戶時間' => 'betweenDate',
            '帳戶生成時間' => 'betweenDate',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        return $parameters;
    }

    public function getData(Request $request)
    {
        // $Clients = Client::with(['AyersAccounts', 'IDCard'])->whereHasMorph('IDCard', [
        //     ClientCNIDCard::class,
        //     ClientHKIDCard::class,
        //     ClientOtherIDCard::class,
        // ], function (Builder $query) {
        //     $query->where('status', 'audited2');
        // })->whereHas('ClientWorkingStatus', function (Builder $query) {
        //     $query->where('status', 'audited2');
        // })->whereHas('ClientFinancialStatus', function (Builder $query) {
        //     $query->where('status', 'audited2');
        // })->whereHas('ClientInvestmentExperience', function (Builder $query) {
        //     $query->where('status', 'audited2');
        // })->whereHas('ClientEvaluationResults', function (Builder $query) {
        //     $query->where('status', 'audited2');
        // })->whereHas('ClientSignature', function (Builder $query) {
        //     $query->where('status', 'audited2');
        // })->where('status', 'audited2')->orderBy('updated_at', 'asc')->get();
        $Clients = ViewDeliverableClient::orderBy('updated_at', 'asc')->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $row['帳戶號碼'] = $Client->account_no;
            $row['開通賬戶類型'] = $Client->type;
            $row['客户姓名'] = $Client->name_c;
            $row['證件號碼'] = $Client->idcard_no;
            $row['手機號碼'] = $Client->mobile;
            $row['郵箱'] = $Client->email;
            $row['開戶時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
            $row['帳戶生成時間'] = date_format($Client->created_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $rows[] = $row;
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
