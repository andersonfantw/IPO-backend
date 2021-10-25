<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Imports\TradeGoCashInImport as _TradeGoCashInImport;
use Excel;
use Carbon\Carbon;

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

    private function readCSV($csvFile, $array)
    {
        $string = Storage::disk('sftp')->get($csvFile);
        $lines = str_getcsv($string, "\n");
        $csv = [];
        if (!empty($lines)) {
            $h = str_getcsv($lines[0], ",");
            for ($i = 1; $i < count($lines); $i++) {
                $l = str_getcsv($lines[$i], ",");
                $row = [];
                for ($j = 0; $j < count($l); $j++) {
                    $row[$h[$j]] = $l[$j];
                }
                $csv[] = $row;
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
            return preg_match("/cash_in.+\.csv$/i", $file);
        });
        $images = array_filter($files, function ($file) {
            return preg_match("/\.(jpeg|png)$/i", $file);
        });
        sort($csvs);
        sort($images);
        for ($i = 0; $i < count($csvs); $i++) {
            $image = Storage::disk('sftp')->get($images[$i]);
            // $=$this->readCSV($csvs[$i], array('delimiter' => ','));
        }
        // foreach ($files as $file) {
        //     Excel::import(new _TradeGoCashInImport, $file, 'sftp')->allOnQueue('TradeGoCashInImport');
        // }
        return 0;
    }
}
