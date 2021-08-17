<?php

namespace App\Http\Controllers;

use App\AE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AeCommissionSummaryController extends HomeController
{
    protected $name = 'AeCommissionSummary';

    public function indexView(Request $request){
        return parent::index($request);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->only('month','ae');

        $result = []; $hash = [];
        $AE = AE::select('name')->selectRaw("group_concat(code) as codes");
        if($input['ae']!='all'){
            $AE->where('uuid','=',$input['ae']);
        }
        $AE = $AE->groupBy('uuid','name')->get()->toArray();
        
        // $ae = [
        //     'LSH01'=>'LSH01,AELSH',
        //     'WHC01'=>'WHC01,AEWHC,AEWHC1'
        // ];
        if($input['month']==''){
            $start_date = Carbon::today()->format('Y-m').'-01';
            $end_date = Carbon::today()->endOfMonth()->format('Y-m-d');
        }elseif($input['month']=='2021-07'){
            $start_date = '2021-04-01';
            $end_date = '2021-07-31';
        }else{
            $d = explode('-',$input['month']);
            $start_date = Carbon::create($d[0],$d[1],1)->format('Y-m-d');
            $end_date = Carbon::create($d[0],$d[1],1)->endOfMonth()->format('Y-m-d');
        }
        $arr = [];
        foreach(['alloted08','alloted13','fee08','fee13','interest08','interest13','principal','sell08','sell13'] as $i){
            $arr[$i]['cate'] = $i;
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','bonus_application1','num'] as $j) $arr[$i][$j] = 0;
        }
        foreach($AE as $v){
            $hash = $arr; 
            foreach(DB::select(sprintf("call sp_ae_commission('%s','%s','%s')",$v['codes'],$start_date,$end_date)) as $r) $hash[$r->cate] = collect($r)->toArray();
            $arr1 = array(
                'id' => 0,
                'name' => $v['name'],
                'type' => '銷售代表',
                'month' => '2021-08',
                'qualified' => $hash['principal']['num'],
                'excitation' => $hash['principal']['bonus_application'],
                'commission1' => $hash['principal']['bonus_application']
                    +$hash['fee08']['bonus_application']
                    +$hash['fee13']['bonus_application']
                    +$hash['interest08']['bonus_application']
                    +$hash['interest13']['bonus_application']
                    +$hash['alloted08']['bonus_application']
                    +$hash['alloted13']['bonus_application']
                    +$hash['fee08']['ae_application_cost']
                    +$hash['fee13']['ae_application_cost']
                    +$hash['interest08']['ae_application_cost']
                    +$hash['interest13']['ae_application_cost'],
                'commission2' => $hash['sell08']['bonus_application'],
                'content' => '',
            );
            $arr1['subtitle'] = $arr1['excitation'] + $arr1['commission1'] + $arr1['commission2'];
            $arr1['reservations'] = $arr1['subtitle']/10;
            $arr1['commission'] = $arr1['subtitle']-$arr1['reservations'];
            $result[] = $arr1;
        }
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function aeList(){
        return AE::select('name as text')->selectRaw('group_concat(code) as value')->groupBy('name')->get();
    }

    public function aeConfirm(){
        $result = []; $hash = [];
        $ae = [
            'LSH01'=>'LSH01,AELSH',
        ];
        $arr = [];
        foreach(['alloted08','alloted13','fee08','fee13','interest08','interest13','principal','sell08','sell13'] as $i){
            $arr[$i]['cate'] = $i;
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','bonus_application1','num'] as $j) $arr[$i][$j] = 0;
        }

        $k = 'LSH01';
        $hash = $arr;
        foreach(DB::select(sprintf("call sp_ae_commission('%s','2021-06-01','2021-07-31')",$ae[$k])) as $r) $hash[$r->cate] = collect($r)->toArray();
        $result = array_merge([
            'id' => 0,
            'name' => $k,
            'type' => '銷售代表',
            'month' => '2021-08',
        ],$hash);
        $result['subtitle'] = $result['principal']['bonus_application1']
            + $result['fee08']['bonus_application'] + $result['fee13']['bonus_application']
            + $result['interest08']['bonus_application'] + $result['interest13']['bonus_application']
            + $result['alloted08']['bonus_application'] + $result['alloted13']['bonus_application']
            + $result['alloted08']['application_cost'] + $result['alloted13']['application_cost']
            + $result['interest08']['application_cost'] + $result['interest13']['application_cost']
            + $result['sell08']['ae_application_cost'] + $result['sell13']['ae_application_cost'];
        //$result['reservations'] = $result['subtitle']/10;
        //$result['commission'] = $result['subtitle']-$result['reservations'];
        return view('pdf/AeCommissionConfirmForm',[
            'logo' => $this->imagePathToBase64(public_path('images/logo.png')),
            'watermark' => $this->imagePathToBase64(public_path('images/ccyss-removebg-preview.png')),
            'data' => $result,
        ]);
    }
}
