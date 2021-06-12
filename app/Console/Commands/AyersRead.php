<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class AyersRead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayers:read {file : a01,a02...a07 } {date : format yyyymmd }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '讀取ayers檔案';

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
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $files = [
            'a01' => 'Ayers/{Ym}/{Ymd}/Client_Fund_In_Out_Listing_CSV01_{Ymd}.csv',
            'a02' => 'Ayers/{Ym}/{Ymd}/Client_Listing_CSV02_{Ymd}.csv',
        ];
        $files = [
            'a01' => 'Ayers/Client_Fund_In_Out_Listing_CSV01.csv',
            'a02' => 'Ayers/Client_Listing_CSV02.csv',
        ];
        $fn = $this->argument('file');
        if(!array_key_exists($fn, $files)) throw new FileNotFoundException($fn);

        $date = Carbon::createFromFormat('Ymd',$this->argument('date'));
        $path = strtr($files[$fn],[
            '{Ym}' => $date->format('Ym'),
            '{Ymd}' => $date->format('Ymd'),
        ]);

        if(!Storage::exists($path)) throw new FileNotFoundException($path);

        $handle = fopen(Storage::path($path), "r");
        $fp = fopen('php://output','w');
        $line=0;
        while(!feof($handle))
        {
            $content = fread($handle, 1024*8);
            if(!$line) $content = $this->remove_utf8_bom($content);
            //echo $content;
            fwrite($fp,mb_convert_encoding($content,"utf-8","big5"));
            flush();
            $line++;
        }
        fclose($handle);
        fclose($fp);
        return 0;
    }

    function remove_utf8_bom($text)
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
