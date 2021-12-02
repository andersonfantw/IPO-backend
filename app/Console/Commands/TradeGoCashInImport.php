<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Imports\TradeGoCashInImport as _TradeGoCashInImport;
use Excel;
use Carbon\Carbon;
use App\ClientAyersAccount;
use App\ClientFundInRequest;
use App\ClientBankCard;

class TradeGoCashInImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tradego:cashinimport {date : today,format yyyymmdd }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '匯入trade go cashin csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function readCSV($csvFile)
    {
        $string = Storage::disk('sftp')->get($csvFile);
        $lines = str_getcsv($string, "\n");
        $csv = [];
        if (!empty($lines)) {
            $h = str_getcsv($lines[0], ",");
            for ($i = 1; $i < count($lines); $i++) {
                $l = str_getcsv($lines[$i], ",");
                // $row = [];
                for ($j = 0; $j < count($l); $j++) {
                    $csv[$h[$j]] = $l[$j];
                }
                // $csv[] = $row;
            }
        }
        return $csv;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = $this->argument('date');
        if ($date == 'today') {
            $date = Carbon::now()->format('Ymd');
        }
        $files = Storage::disk('sftp')->files($date);
        $csvs = array_filter($files, function ($file) {
            return preg_match("/cash_in.+_1\.csv$/i", $file);
        });
        $images = array_filter($files, function ($file) {
            return preg_match("/\_1.(jpg|jpeg|png)$/i", $file);
        });
        sort($csvs);
        sort($images);
        for ($i = 0; $i < count($csvs); $i++) {
            $image = Storage::disk('sftp')->get($images[$i]);
            $csv = $this->readCSV($csvs[$i]);
            $ClientAyersAccount = ClientAyersAccount::with(['Client.ClientBankCards' => function ($query) {
                $query->where('lcid', 'zh-hk')->orWhere('lcid', 'others');
            }])->where('account_no', $csv['ccclnld'])->first();
            $bank_name = explode(" ", $csv['bank_name']);
            $remark = explode(";", $csv['remark']);
            $ClientBankCard = $ClientAyersAccount->Client->ClientBankCards->first();
            ClientFundInRequest::firstOrCreate(
                [
                    'uuid' => $ClientAyersAccount->uuid,
                    'transfer_time' => trim($csv['cash_in_date']).':00',
                ],
                [
                    'bank' => $bank_name[0],
                    'bank_account' => $csv['bank_acc_id'],
                    'account_in' => $csv['ccclnld'],
                    'amount' => $csv['amount'],
                    'method' => $remark[2],
                    // 'status' => 'pending',
                    // 'issued_by',
                    // 'remark',
                    'receipt' => $image,
                    'bankcard' => $ClientBankCard->bankcard_blob,
                    'timezone' => 8,
                    // 'previewing_by',
                ]
            );
            // var_dump($csv);
        }
        // foreach ($files as $file) {
        //     Excel::import(new _TradeGoCashInImport, $file, 'sftp')->allOnQueue('TradeGoCashInImport');
        // }
        return 0;
    }
}
