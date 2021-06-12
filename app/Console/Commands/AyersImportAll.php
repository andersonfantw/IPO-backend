<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AyersImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayers:importall {period : today,2020,2021} {file : All,A01,A02...A07 }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批次匯入Ayers css檔';

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
        if(!array_key_exists($this->argument('period'), $this->csvs)){
            $this->line(sprintf('invalid period `%s`',$this->argument('period')));
            return 0;
        }
        if(!array_key_exists($this->argument('file'), $this->csvs[$this->argument('period')])){
            $this->line(sprintf('invalid file `%s`',$this->argument('file')));
            return 0;
        }

        $params = [];
        $arr_date = [];
        $arr_file = [];

        if($this->argument('period')=='today'){
            if($this->argument('file')=='All'){
                $arr_file = array_filter(array_keys($this->csvs['today']),function($v){
                    return $v!='All';
                });
            }else{
                $arr_file = [$this->argument('file')];
            }
            foreach($arr_file as $v){
                $params[] = ['file'=>$v, 'date'=> date('Ymd')];
            }
        }else{
            if($this->argument('file')=='All') {
                foreach ($this->csvs[$this->argument('period')] as $k => $v) {
                    if ($k == 'All') continue;
                    foreach($this->data[$this->argument('period')][$v] as $d){
                        $params[] = ['file' => $k, 'date' => $d];
                    }
                }
            }else{
                foreach ($this->data[$this->argument('period')][$this->csvs[$this->argument('period')][$this->argument('file')]] as $d){
                    $params[] = ['file' => $this->argument('file'), 'date' => $d];
                }
            }
        }

        foreach($params as $p){
            try {
                $this->line('import ' . $p['date'] . ' ' . $p['file']);
                Artisan::call('ayers:import', $p);
            }catch(\Illuminate\Contracts\Filesystem\FileNotFoundException $e){
                $this->error('Missing file '.$e->getMessage());
            }
        }
        return 0;
    }


    private $csvs = [
        'today' => [
            'All' => '',
            'A01' => 'daily',
            'A02' => 'daily',
            'A03' => 'daily',
            'A04' => 'daily',
            'A05' => 'daily',
            'A06' => 'daily',
            'A07' => 'daily',
            'AProductInfo' => 'daily',
            'AClientAcc' => 'daily',
        ],
        '2020' => [
            'All' => '',
            'A01' => 'daily',
            'A02' => 'all',
            'A03' => 'all',
            'A04' => 'daily',
            'A05' => 'daily',
            'A06' => 'all',
            'A07' => 'monthly',
            'AProductInfo' => 'all',
            'AClientAcc' => 'all',
        ],
        '2021' => [
            'All' => '',
            'A01' => 'daily',
            'A02' => 'all',
            'A03' => 'all',
            'A04' => 'daily',
            'A05' => 'daily',
            'A06' => 'daily',
            'A07' => 'monthly',
            'AProductInfo' => 'all',
            'AClientAcc' => 'all',
        ],
    ];
    /**
     * 2021-04-14前為第一期資料
     * 2021-04-15開始為第二期資料
     */
    private $data = [
        '2020' => [
            'daily' => [
                '20200831',
                '20200901','20200902','20200903','20200904','20200907','20200908','20200909','20200910','20200911','20200914','20200915',
                '20200916','20200917','20200918','20200921','20200922','20200923','20200924','20200925','20200928','20200929','20200930',
                '20201005','20201006','20201007','20201008','20201009','20201012','20201014','20201015','20201016','20201019','20201020',
                '20201021','20201022','20201023','20201027','20201028','20201029','20201030',
                '20201102','20201103','20201104','20201105','20201106','20201109','20201110','20201111','20201112','20201113','20201116',
                '20201117','20201118','20201119','20201120','20201123','20201124','20201125','20201126','20201127','20201130',
                '20201201','20201202','20201203','20201204','20201207','20201208','20201209','20201210','20201211','20201214','20201215',
                '20201216','20201217','20201218','20201221','20201222','20201223','20201224','20201228','20201229','20201230','20201231',
                '20210104','20210105','20210106','20210107','20210108','20210111','20210112','20210113','20210114','20210115','20210118',
                '20210119','20210120','20210121','20210122','20210125','20210126','20210127','20210128','20210129',
                '20210201','20210202','20210203','20210204','20210205','20210208','20210209','20210210','20210211','20210216','20210217',
                '20210218','20210219','20210222','20210223','20210224','20210225','20210226',
                '20210301','20210302','20210303','20210304','20210305','20210308','20210309','20210310','20210311','20210312','20210315',
                '20210316','20210317','20210318','20210319','20210322','20210323','20210324','20210325','20210326','20210329','20210330','20210331',
                '20210401','20210407','20210408','20210409','20210412','20210413','20210414',
            ],
            'monthly' => [
                '20200831',
                '20200930',
                '20201030',
                '20201130',
                '20201231',
                '20210129',
                '20210226',
                '20210331',
            ],
            'all' => ['20210414'],
        ],
        '2021' => [
            'daily' => [
                '20210415','20210416','20210419','20210420','20210421','20210422','20210423','20210426','20210427','20210428','20210429','20210430',
                '20210503','20210504','20210505','20210506','20210507','20210510','20210511','20210512','20210513','20210514','20210517',
            ],
            'monthly' => [
                '20210430',
                '20210517',
            ],
            'all' => ['20210517'],
        ],

    ];
}
