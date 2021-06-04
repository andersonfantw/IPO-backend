<?php

namespace App\Console\Commands;

use App;
use App\A07;
use App\Imports\ChunkReadFilter;
use Illuminate\Console\Command;
use MyCSV;

class ImportA07 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'a07:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import ayers csv 07';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // $client = new \Redis();
        // $client->connect(env('REDIS_HOST'), env('REDIS_PORT'));
        // $pool = new \Cache\Adapter\Redis\RedisCachePool($client);
        // $simpleCache = new \Cache\Bridge\SimpleCache\SimpleCacheBridge($pool);
        // \PhpOffice\PhpSpreadsheet\Settings::setCache($simpleCache);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $fileName = 'D:\\银盛证券\\Ayers\\testing.csv';
        // /**  Create a new Reader of the type defined in $inputFileType  **/
        // $reader = MyCSV::getReader();
        // $reader->setReadDataOnly(true);
        // // $encoding = \PhpOffice\PhpSpreadsheet\Reader\Csv::guessEncoding($fileName);
        // /**  Define how many rows we want to read for each "chunk"  **/
        // $chunkSize = 1000;
        // $endRow = $chunkSize;
        // /**  Create a new Instance of our Read Filter  **/
        // $chunkFilter = new ChunkReadFilter();
        // /**  Tell the Reader that we want to use the Read Filter  **/
        // $reader->setReadFilter($chunkFilter);
        // /**  Loop to read our worksheet in "chunk size" blocks  **/
        // for ($startRow = 2; $startRow <= $endRow; $startRow += $chunkSize) {
        //     /**  Tell the Read Filter which rows we want this iteration  **/
        //     $chunkFilter->setRows($startRow, $chunkSize);
        //     /**  Load only the rows that match our filter  **/
        //     $spreadsheet = $reader->load($fileName);
        //     // $worksheet = $spreadsheet->getActiveSheet();
        //     $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        //     $header = $rows[1];
        //     for ($i = $startRow; $i < count($rows); $i++) {
        //         $row = $rows[$i];
        //         $rowkv = array_combine($header, $row);
        //         $pk = [
        //             'client_acc_id' => $rowkv['client_acc_id'],
        //             'ccy' => $rowkv['ccy'],
        //             'dayend_date' => $rowkv['dayend_date'],
        //         ];
        //         unset($rowkv['client_acc_id']);
        //         unset($rowkv['ccy']);
        //         unset($rowkv['dayend_date']);
        //         A07::updateOrCreate($pk, $rowkv);
        //     }
        //     if (count($rows) + 1 - $startRow >= $chunkSize) {
        //         $endRow += $chunkSize;
        //     }
        // }
        return 0;
    }
}
