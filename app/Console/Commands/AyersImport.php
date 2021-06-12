<?php

namespace App\Console\Commands;

use App\Jobs\ImportJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Storage;

class AyersImport extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayers:import {file : All,A01,A02...A07 } {date : format yyyymmd }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '匯入單一Ayers csv檔';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = [
            'A01' => 'Ayers/{Ym}/{Ymd}/Client_Fund_In_Out_Listing_CSV01_{Ymd}.csv',
            'A02' => 'Ayers/{Ym}/{Ymd}/Client_Listing_CSV02_{Ymd}.csv',
            'A03' => 'Ayers/{Ym}/{Ymd}/Client_Product_Balance_CSV03_{Ymd}.csv',
            'A04' => 'Ayers/{Ym}/{Ymd}/Client_Trade_Journal_Listing_CSV04_{Ymd}.csv',
            'A05' => 'Ayers/{Ym}/{Ymd}/Client_Trade_Journal_w_Chrg_Details_CSV05_{Ymd}.csv',
            'A06' => 'Ayers/{Ym}/{Ymd}/IPO_Subscription_Detail_Listing_CSV06_{Ymd}.csv',
            'A07' => 'Ayers/{Ym}/{Ymd}/Client_Interest_Statement_CSV07_{Ymd}.csv',
            'AProductInfo' => 'Ayers/{Ym}/{Ymd}/CYSISL_product_info_{Ymd}.csv',
            'AClientAcc' => 'Ayers/{Ym}/{Ymd}/CYSISLB_gts_client_acc_{Ymd}.csv',
        ];
        // $files = [
        //     'A01' => 'Ayers/Client_Fund_In_Out_Listing_CSV01.csv',
        //     'A02' => 'Ayers/Client_Listing_CSV02.csv',
        //     'A03' => 'Ayers/Client_Product_Balance_CSV03.csv',
        //     'A04' => 'Ayers/Client_Trade_Journal_Listing_CSV04.csv',
        //     'A05' => 'Ayers/Client_Trade_Journal_w_Chrg_Details_CSV05.csv',
        //     'A06' => 'Ayers/IPO_Subscription_Detail_Listing_CSV06.csv',
        //     'A07' => 'Ayers/Client_Interest_Statement_CSV07.csv',
        //     'AProductInfo' => 'Ayers/CYSISL_product_info.csv',
        //     'AClientAcc' => 'Ayers/CYSISLB_gts_client_acc.csv',
        // ];
        $fn = $this->argument('file');
        $date = Carbon::createFromFormat('Ymd',$this->argument('date'));

        try {
            if($fn=='All'){
                $_files = array_keys($files);
            }else{
                if(!array_key_exists($fn, $files)) throw new FileNotFoundException($fn);
                $_files = [$fn];    
            }

            foreach($_files as $fn){
                $path = strtr($files[$fn],[
                    '{Ym}' => $date->format('Ym'),
                    '{Ymd}' => $date->format('Ymd'),
                ]);

                if(!Storage::disk('ayers')->exists($path)) throw new FileNotFoundException($path);

                $class = 'App\Imports\\'.$fn.'Import';
                (new $class)->import(Storage::disk('ayers')->path($path), null, \Maatwebsite\Excel\Excel::CSV)->allOnQueue('AyersCSVImport');

                $this->line('import ' . $this->argument('date') . ' ' . $fn);
            }
        }catch(\Illuminate\Contracts\Filesystem\FileNotFoundException $e){
            $this->error('Missing file '.$e->getMessage());
        }

        return 0;
    }
}