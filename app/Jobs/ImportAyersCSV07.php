<?php

namespace App\Jobs;

use App\Imports\A07Import;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportAyersCSV07 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $a07;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->a07 = $a07;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Excel::queueImport(new A07Import, 'D:\\银盛证券\\Ayers\\202104\\20210422\\Client_Interest_Statement_CSV07_20210422.csv');
    }
}
