<?php

namespace App\Http\Controllers;

use App\AE;
use App\AeCommissionSummary;
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
        $month = ($input['month']=='')?Carbon::today()->format('Y-m').'-01':$input['month'].'-01';
        $arr = [];
        foreach(['principal','alloted','fee','interest','sell'] as $i){
            $arr[$i]['cate'] = $i;
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','transaction_number'] as $j) $arr[$i][$j] = 0;
        }
        foreach($AE as $v){
            $hash = $arr; 
            if($v['name']=='梧桐花開'){
                $v['name']='王浩進';
                $v['codes'] = $v['codes'].',AEWHC';
            }
            foreach(AeCommissionSummary::where('ae_codes','=',$v['codes'])->where('buss_date','=',$month)->get()->toArray() as $r) $hash[$r['cate']] = collect($r)->toArray();
            $arr1 = array(
                'id' => 0,
                'name' => $v['name'],
                'uuid' => $v['uuid'],
                'codes' => $v['codes'],
                'type' => '銷售代表',
                'month' => $month,
                'qualified' => $hash['principal']['transaction_number_correction']??$hash['principal']['transaction_number'],
                'excitation' => $hash['principal']['bonus_application_correction']??$hash['principal']['bonus_application'],
                'commission1' => $hash['fee']['bonus_application_correction']??$hash['fee']['bonus_application']
                    +$hash['interest']['bonus_application_correction']??$hash['interest']['bonus_application']
                    +$hash['alloted']['bonus_application_correction']??$hash['alloted']['bonus_application']
                    +$hash['fee']['ae_application_cost_correction']??$hash['fee']['ae_application_cost']
                    +$hash['interest']['ae_application_cost_correction']??hash['interest']['ae_application_cost'],
                'commission2' => $hash['sell']['bonus_application_correction'],
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
    public function show($id, Request $request)
    {
        $input = $request->only('month');
        $result = $this->aeConfirmData($id,$input['month']);
        return [
            'calculate' => [
                'fee'=>$result['data']['fee']['application_fee'],
                'interest'=>$result['data']['interest']['application_fee'],
                'alloted'=>$result['data']['alloted']['application_fee'],
                'fee_cost'=>$result['data']['fee']['application_cost'],
                'interest_cost'=>$result['data']['interest']['application_cost'],
                'sell'=>$result['data']['sell']['application_fee'],
                'principal'=>$result['data']['principal']['bonus_application'],
                'principal_number'=>(string)$result['data']['principal']['transaction_number'],
                'accumulated_provision'=>0,
            ],
            'modify' => [
                'fee'=>$result['data']['fee']['application_fee_correction'],
                'interest'=>$result['data']['interest']['application_fee_correction'],
                'alloted'=>$result['data']['alloted']['application_fee_correction'],
                'fee_cost'=>$result['data']['fee']['application_cost_correction'],
                'interest_cost'=>$result['data']['interest']['application_cost_correction'],
                'sell'=>$result['data']['sell']['application_fee_correction'],
                'principal_number'=>(string)$result['data']['principal']['transaction_number_correction'],
                'other'=>$result['data']['other']['application_fee_correction']??'',
            ],
        ];
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
        $input = $request->only('month');

        return view('pdf/AeCommissionConfirmForm',$this->aeConfirmData($uuid,$input['month'],$input['end']));
    }
    public function aeConfirmReport(string $uuid, Request $request){
        $input = $request->only('month');

        $pdf = PDF::loadView('pdf.AeCommissionConfirmForm', $this->aeConfirmData($uuid,$input['month'],$input['end']));
        return $pdf->stream('AeCommissionConfirmForm.pdf');
        // $pdf->setOptions(['isPhpEnabled' => true]);
        // return ['ok'=>true,'msg'=>'','PDF'=>$pdf];
    }

    private function aeConfirmData($uuid, $month): array
    {
        $result = []; $hash = [];
        $AE = AE::select('uuid','name')
            ->selectRaw('group_concat(code) as codes')
            ->where('uuid','=',$uuid)
            ->groupBy('uuid','name')->first()->toArray();
        // $ae = [
        //     'LSH01'=>'LSH01,AELSH',
        // ];
        if($AE['name']=='梧桐花開'){
            $AE['name']='王浩進';
            $AE['codes'] = $AE['codes'].',AEWHC';
        }
        $arr = [];
        foreach(['principal','alloted','fee','interest','sell'] as $i){
            $arr[$i]['cate'] = $i;
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','transaction_number'] as $j) $arr[$i][$j] = 0;
        }

        $hash = $arr;
        foreach(AeCommissionSummary::where('ae_codes','=',$AE['codes'])->where('buss_date','=',$month)->get()->toArray() as $r) $hash[$r['cate']] = collect($r)->toArray();
        $result = array_merge([
            'id' => 0,
            'name' => $AE['name'],
            'type' => '銷售代表',
            'codes' => $AE['codes'],
            'uuid' => $AE['uuid'],
            'month' => $month,
        ],$hash);
        $result['subtitle'] = $result['principal']['bonus_application']
            + $result['fee']['bonus_application']
            + $result['interest']['bonus_application']
            + $result['alloted']['bonus_application']
            + $result['fee']['ae_application_cost']
            + $result['interest']['ae_application_cost']
            + $result['sell']['bonus_application'];
        //$result['reservations'] = $result['subtitle']/10;
        //$result['commission'] = $result['subtitle']-$result['reservations'];
        return [
            'logo' => $this->imagePathToBase64(public_path('images/logo.png')),
            'watermark' => $this->imagePathToBase64(public_path('images/ccyss-removebg-preview.png')),
            'data'=>$result
        ];
    }
}
