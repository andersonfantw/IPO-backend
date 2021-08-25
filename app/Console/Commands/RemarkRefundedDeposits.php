<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class RemarkRefundedDeposits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refundeddeposits:remark {date : format yyyymmd }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '備註已退還存款';

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
        $files = 'Finance/{Ym}/{Ymd}/Deposit.xlsx';

        $date = Carbon::createFromFormat('Ymd', $this->argument('date'));
        $path = strtr($files, [
            '{Ym}' => $date->format('Ym'),
            '{Ymd}' => $date->format('Ymd'),
        ]);

        if (!Storage::exists($path)) {
            throw new FileNotFoundException($path);
        }

        $handle = fopen(Storage::path($path), "r");
        $fp = fopen('php://output', 'w');
        $line = 0;
        while (!feof($handle)) {
        }

        return 0;
    }
}
