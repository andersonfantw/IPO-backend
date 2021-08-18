<?php

namespace App\Http\Controllers;

use App\AE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

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
        $AE = AE::select('uuid','name')->selectRaw("group_concat(code) as codes");
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
            $start_date = '2021-03-01';
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
                'uuid' => $v['uuid'],
                'type' => '銷售代表',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'qualified' => $hash['principal']['num'],
                'excitation' => $hash['principal']['bonus_application'],
                'commission1' => $hash['fee08']['bonus_application']
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

    public function aeConfirm(string $uuid, Request $request){
        $input = $request->only('start','end');

        return view('pdf/AeCommissionConfirmForm',$this->aeConfirmData($uuid,$input['start'],$input['end']));
    }
    public function aeConfirmReport(string $uuid, Request $request){
        $input = $request->only('start','end');

        $pdf = PDF::loadView('pdf.AeCommissionConfirmForm', $this->aeConfirmData($uuid,$input['start'],$input['end']));
        return $pdf->stream('AeCommissionConfirmForm.pdf');
        // $pdf->setOptions(['isPhpEnabled' => true]);
        // return ['ok'=>true,'msg'=>'','PDF'=>$pdf];
    }

    private function aeConfirmData($uuid, $start_date, $end_date): array
    {
        $result = []; $hash = [];
        $AE = AE::select('uuid','name')
            ->selectRaw('group_concat(code) as codes')
            ->where('uuid','=',$uuid)
            ->groupBy('uuid','name')->first();
        // $ae = [
        //     'LSH01'=>'LSH01,AELSH',
        // ];
        $arr = [];
        foreach(['alloted08','alloted13','fee08','fee13','interest08','interest13','principal','sell08','sell13'] as $i){
            $arr[$i]['cate'] = $i;
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','bonus_application1','num'] as $j) $arr[$i][$j] = 0;
        }

        $hash = $arr;
        foreach(DB::select(sprintf("call sp_ae_commission('%s','%s','%s')",$AE->codes,$start_date,$end_date)) as $r) $hash[$r->cate] = collect($r)->toArray();
        $result = array_merge([
            'id' => 0,
            'name' => $AE->name,
            'type' => '銷售代表',
            'codes' => $AE->codes,
            'uuid' => $AE->uuid,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ],$hash);
        $result['subtitle'] = $result['principal']['bonus_application1']
            + $result['fee08']['bonus_application'] + $result['fee13']['bonus_application']
            + $result['interest08']['bonus_application'] + $result['interest13']['bonus_application']
            + $result['alloted08']['bonus_application'] + $result['alloted13']['bonus_application']
            + $result['fee08']['ae_application_cost'] + $result['fee13']['ae_application_cost']
            + $result['interest08']['ae_application_cost'] + $result['interest13']['ae_application_cost']
            + $result['sell08']['bonus_application'] + $result['sell13']['bonus_application'];
        //$result['reservations'] = $result['subtitle']/10;
        //$result['commission'] = $result['subtitle']-$result['reservations'];
        return [
            'logo' => $this->imagePathToBase64(public_path('images/logo.png')),
            'watermark' => $this->imagePathToBase64(public_path('images/ccyss-removebg-preview.png')),
            'data'=>$result
        ];
    }
}
