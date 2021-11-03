<?php

namespace App\Http\Controllers;

use App\AE;
use App\Staff;
use App\AeCommissionSummary;
use App\TempClientBonusWithDummy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Exports\CommissionDetail;
use Carbon\Carbon;
use PDF;
use App\Traits\Report;

class AeCommissionSummaryController extends HomeController
{
    use Report;

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
        $month = ($input['month']=='')?Carbon::today()->format('Y-m').'-01':$input['month'].'-01';
        $ae_uuid = ($input['ae']=='all')?null:$input['ae'];
        $result = $this->aeCommissionSummaryData($month,$ae_uuid);
        return array_filter($result, function($k){
            return in_array($k,['data','group']);
        },ARRAY_FILTER_USE_KEY);
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
        $input = $request->only('month','staff','num','bonus','content');
        $AeCommissionSummary = AeCommissionSummary::firstOrCreate([
            'buss_date'=>$input['month'].'-01',
            'ae_uuid'=>$input['staff'],
            'ae_codes'=>$input['staff'],
        ],[
            'cate'=>'principal',
            'transaction_number_correction'=>$input['num'],
            'bonus_application_correction'=>$input['bonus'],
            'content'=>$input['content'],
        ]);
        $result = ['ok'=>$AeCommissionSummary->wasRecentlyCreated];
        if(!$AeCommissionSummary->wasRecentlyCreated) $result = array_merge($result,['msg'=>'不能建立重複的紀錄!']);
        return $result;
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
    public function edit($id, Request $request)
    {
        $input = $request->only('month');
        $result = $this->aeConfirmData($id,$input['month']);
        return [
            'calculate' => [
                'pay_date'=>$result['principal']['pay_date']
                    ??$result['fee']['pay_date']
                    ??$result['interest']['pay_date']
                    ??$result['alloted']['pay_date']
                    ??$result['sell']['pay_date']
                    ??null,
                'fee'=>$result['fee']['application_fee'],
                'fee_bonus'=>$result['fee']['bonus_application'],
                'interest'=>$result['interest']['application_fee'],
                'interest_bonus'=>$result['interest']['bonus_application'],
                'alloted'=>$result['alloted']['application_fee'],
                'alloted_bonus'=>$result['alloted']['bonus_application'],
                'fee_cost'=>$result['fee']['application_cost'],
                'ae_fee_cost'=>$result['fee']['ae_application_cost'],
                'interest_cost'=>$result['interest']['application_cost'],
                'ae_interest_cost'=>$result['interest']['ae_application_cost'],
                'sell'=>$result['sell']['application_fee'],
                'sell_bonus'=>$result['sell']['bonus_application'],
                'principal'=>$result['principal']['bonus_application'],
                'principal_number'=>(string)$result['principal']['transaction_number'],
                'accumulated_provision'=>$result['accumulated_provision'],
            ],
            'modify' => [
                'fee'=>$result['fee']['application_fee_correction']??null,
                'interest'=>$result['interest']['application_fee_correction']??null,
                'alloted'=>$result['alloted']['application_fee_correction']??null,
                'fee_cost'=>$result['fee']['application_cost_correction']??null,
                'interest_cost'=>$result['interest']['application_cost_correction']??null,
                'sell'=>$result['sell']['application_fee_correction']??null,
                'principal_number'=>(string)$result['principal']['transaction_number_correction']??null,
                'other'=>$result['other']['ae_application_cost_correction']??null,
            ],
        ];
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
        $input = $request->only('month','fee','interest','alloted','fee_cost','interest_cost','sell','principal_number','other');
        $AE = AE::select('uuid','name')
            ->selectRaw("group_concat(code) as codes")
            ->where('uuid','=',$id)
            ->groupBy('uuid','name')
            ->first()->toArray();
        if($AE['name']=='梧桐花開'){
            $AE['name']='王浩進';
            $AE['codes'] = $AE['codes'].',AEWHC';
        }
        $data = [];
        foreach(['fee','interest','alloted','fee_cost','interest_cost','sell','principal_number','other'] as $item){
            $arr = explode('_',$item);
            $row = array_key_exists($arr[0],$data)
                ?$data[$arr[0]]
                :[
                    'buss_date'=>$input['month'],
                    'ae_uuid'=>$AE['uuid'],
                    'ae_codes'=>$AE['codes'],
                    'cate'=>$arr[0],
                    'application_fee_correction'=>null,
                    'bonus_application_correction'=>null,
                    'application_cost_correction'=>null,
                    'ae_application_cost_correction'=>null,
                    'transaction_number_correction'=>null
                ];
            $v = is_numeric($input[$item])?$input[$item]:null;
            if($arr[0]=='other'){
                AeCommissionSummary::updateOrCreate(
                    ['buss_date'=>$input['month'],'ae_codes'=>$AE['codes'],'ae_uuid'=>$AE['uuid'],'cate'=>$arr[0]],
                    ['ae_application_cost_correction'=>$v],
                );
                continue;
            }elseif(count($arr)==1){    
                if($v) $row = array_merge($row,[
                    'application_fee_correction' => $v,
                    'bonus_application_correction' => $v*0.6,
                ]);
            }elseif($arr[1]=='cost'){
                if($v) $row = array_merge($row,[
                    'application_cost_correction' => $v,
                    'ae_application_cost_correction' => $v*0.6,
                ]);
            }elseif($arr[1]=='number'){
                if($v) $row = array_merge($row,[
                    'application_fee_correction' => $v * 450,
                    'bonus_application_correction' => $v * 450,
                    'transaction_number_correction' => $v,
                ]);
            }
            $data[$arr[0]] = $row;
        }
        AeCommissionSummary::upsert(
            array_values($data),
            ['buss_date','ae_uuid','cate'],
            ['application_fee_correction','bonus_application_correction','application_cost_correction','ae_application_cost_correction','transaction_number_correction']
        );
        return ['ok'=>true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AeCommissionSummary::destroy($id);
        return ['ok'=>true];
    }

    public function pay(Request $request){
        $input = $request->only('selected');
        $data = [];
        foreach(explode(',',$input['selected']) as $item){
            $k = explode('@',base64_decode($item));
            // 紀錄付款時間, 人員
            AeCommissionSummary::where('buss_date','=',$k[0])
                ->where('ae_uuid','=',$k[1])
                ->update([
                    'pay_date'=>now(),
                    'issued_by'=>auth()->user()->name,
                ]);
            // 紀錄發出給AE的獎金金額與保留數
            AeCommissionSummary::create([
                'buss_date'=>$k[0],
                'ae_uuid'=>$k[1],
                'ae_codes'=>$k[1],
                'pay_date'=>now(),
                'issued_by'=>auth()->user()->name,
                'cate'=>'commission',
                'bonus_application_correction'=>$k[3],
                'ae_application_cost_correction'=>$k[2],
            ]);
        }

        // 如果本月的獎金皆發出，則立即記錄團體獎金
        $unpaid = AeCommissionSummary::whereDate('buss_date','=',$k[0])->whereNull('pay_date')->count();
        if($unpaid==0){
            extract($this->aeCommissionSummaryData($k[0]));
            $collect = collect($data);
            AeCommissionSummary::firstOrCreate([
                'buss_date'=>$k[0],
                'ae_uuid'=>'group_info',
                'cate'=>'group_info',
            ],[
                'ae_codes'=>'group_info',
                'pay_date'=>now(),
                'issued_by'=>auth()->user()->name,
                'application_fee_correction'=>$collect->sum('performance'),     // 本月業績 1/2 級市場
                'bonus_application_correction'=>$collect->sum('commission'),    // 本月發出獎金
                'application_cost_correction'=>$collect->sum('reservations'),   // 本月所有AE保留數
                'ae_application_cost_correction'=>($collect->sum('performance')-$collect->sum('cost'))*0.1, // 團體提撥獎金
                'transaction_number_correction'=>$collect->sum('qualified'),
            ]);
        }

        return ['ok'=>true];
    }

    public function aeCommissionSummary(string $buss_date, Request $request){
        //$data, $ae, $group
        extract($this->aeCommissionSummaryData($buss_date));
        $licensed_staff_uuid = array_map(function($o){return $o->uuid;},
            array_filter($ae, function($o){return ($o->type=='staff' && $o->has_license=='1');})
        );
        $no_license_staff_uuid = array_map(function($o){return $o->uuid;},
            array_filter($ae, function($o){return ($o->type=='staff' && $o->has_license=='0');})
        );
        $ae_uuid = array_map(function($o){return $o->uuid;},
            array_filter($ae, function($o){return $o->type=='ae';})
        );
        $collect = collect($data);
        return view('pdf/AeCommissionSummaryForm',array_merge(
            [
                'buss_date'=>Carbon::today()->format('Y/m/d'),
                'start_date'=>Carbon::parse($buss_date)->format('Y/m/d'),
                'end_date'=>Carbon::parse($buss_date)->endOfMonth()->format('Y/m/d'),
                'ae'=>array_filter($data, function($row) use($ae_uuid){return in_array($row['uuid'],$ae_uuid);}),
                'licensed_staff'=>array_filter($data, function($row) use($licensed_staff_uuid){return in_array($row['uuid'],$licensed_staff_uuid);}),
                'no_license_staff'=>array_filter($data, function($row) use($no_license_staff_uuid){return in_array($row['uuid'],$no_license_staff_uuid);}),
                'qualified'=>$collect->sum('qualified'),
                'reservations'=>$collect->sum('reservations'),
                'commission'=>$collect->sum('commission'),
                'performance'=>$collect->sum('performance'),
                'total_group_open'=>$group['total_group_open'],
                'total_group_commission'=>$group['total_group_commission'],
            ],
            $this->StylingImages(),
        ));
    }
    public function aeCommissionSummaryReport(string $buss_date, Request $request){
        //$data, $ae
        extract($this->aeCommissionSummaryData($buss_date));

        $licensed_staff_uuid = array_map(function($o){return $o->uuid;},
            array_filter($ae, function($o){return ($o->type=='staff' && $o->has_license=='1');})
        );
        $no_license_staff_uuid = array_map(function($o){return $o->uuid;},
            array_filter($ae, function($o){return ($o->type=='staff' && $o->has_license=='0');})
        );
        $ae_uuid = array_map(function($o){return $o->uuid;},
            array_filter($ae, function($o){return $o->type=='ae';})
        );
        $collect = collect($data);
        $pdf = PDF::loadView('pdf.AeCommissionSummaryForm', array_merge(
            [
                'buss_date'=>Carbon::today()->format('Y/m/d'),
                'start_date'=>Carbon::parse($buss_date)->format('Y/m/d'),
                'end_date'=>Carbon::parse($buss_date)->endOfMonth()->format('Y/m/d'),
                'ae'=>array_filter($data, function($row) use($ae_uuid){return in_array($row['uuid'],$ae_uuid);}),
                'licensed_staff'=>array_filter($data, function($row) use($licensed_staff_uuid){return in_array($row['uuid'],$licensed_staff_uuid);}),
                'no_license_staff'=>array_filter($data, function($row) use($no_license_staff_uuid){return in_array($row['uuid'],$no_license_staff_uuid);}),
                'qualified'=>$collect->sum('qualified'),
                'reservations'=>$collect->sum('reservations'),
                'commission'=>$collect->sum('commission'),
                'performance'=>$collect->sum('performance'),
                'total_group_open'=>$group['total_group_open']??null,
                'total_group_commission'=>$group['total_group_commission']??null,
            ],
            $this->StylingImages(),
        ));
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('AeCommissionSummaryForm.pdf');
    }

    public function aeConfirm(string $uuid, Request $request){
        $input = $request->only('month');

        return view('pdf/AeCommissionConfirmForm', array_merge(
            ['data'=>$this->aeConfirmData($uuid,$input['month'])],
            $this->StylingImages(),
        ));
    }
    public function aeConfirmReport(string $uuid, Request $request){
        $input = $request->only('month');

        $pdf = PDF::loadView('pdf.AeCommissionConfirmForm', array_merge(
            $this->aeConfirmData($uuid,$input['month']),
            $this->StylingImages(),
        ));
        $pdf->setOptions(['isPhpEnabled' => true]);
        return $pdf->stream('AeCommissionConfirmForm.pdf');
    }

    private function aeCommissionSummaryData($month,$ae_uuid=null): array
    {
        $result = []; $hash = [];
        $AE = DB::query()->fromSub(function($query){
            $query->select('uuid','name')
                ->selectRaw('1 as has_license')
                ->selectRaw('group_concat(code) as codes')
                ->selectRaw("'ae' as type")
                ->groupBy('uuid','name')
                ->from('ae')
                ->union(Staff::select('uuid','name','has_license','uuid as codes')->selectRaw("'staff' as type"));
        },'t')->whereIn('uuid',AeCommissionSummary::select('ae_uuid')->distinct()->whereDate('buss_date','=',$month)->get());
        if(!is_null($ae_uuid)) $AE->where('uuid','=',$ae_uuid);
        $AE = $AE->get()->toArray();

        $arr = [];
        foreach(['principal','alloted','fee','interest','sell'] as $i){
            $arr[$i]['cate'] = $i;
            $arr[$i]['pay_date'] = null;
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','transaction_number'] as $j) $arr[$i][$j] = 0;
        }
        foreach($AE as $v){
            $hash = $arr;
            $v = collect($v)->toArray();
            if($v['name']=='梧桐花開'){
                $v['name']='王浩進';
                $v['codes'] = $v['codes'].',AEWHC';
            }
            $AeCommissionSummary = AeCommissionSummary::where('ae_codes','=',$v['codes'])->where('buss_date','=',$month)->get()->toArray();
            foreach($AeCommissionSummary as $r) $hash[$r['cate']] = collect($r)->toArray();

            $arr1 = array(
                'id' => ($v['type']=='ae')?0:$hash['principal']['id'],
                'pay_date' => $hash['principal']['pay_date']??$hash['fee']['pay_date']??$hash['interest']['pay_date']??$hash['alloted']['pay_date']??$hash['sell']['pay_date'],
                'name' => $v['name'],
                'uuid' => $v['uuid'],
                'codes' => $v['codes'],
                'type' => (($v['type']=='ae')?'銷售代表':(($v['has_license']=='1')?'持牌員工':'非持牌員工')),
                'month' => $month,
                'qualified' => $hash['principal']['transaction_number_correction']??$hash['principal']['transaction_number'],
                'excitation' => $hash['principal']['bonus_application_correction']??$hash['principal']['bonus_application'],
                'commission1' => ($hash['fee']['bonus_application_correction']??$hash['fee']['bonus_application'])
                    +($hash['interest']['bonus_application_correction']??$hash['interest']['bonus_application'])
                    +($hash['alloted']['bonus_application_correction']??$hash['alloted']['bonus_application'])
                    +($hash['fee']['ae_application_cost_correction']??$hash['fee']['ae_application_cost'])
                    +($hash['interest']['ae_application_cost_correction']??$hash['interest']['ae_application_cost']),
                'commission2' => ($hash['sell']['bonus_application_correction']??$hash['sell']['bonus_application']),
                'performance' => $hash['fee']['application_fee'] 
                    +$hash['interest']['application_fee'] 
                    +$hash['alloted']['application_fee'] 
                    +$hash['sell']['application_fee'],
                'cost' => $hash['fee']['application_cost'] 
                    +$hash['interest']['application_cost'] 
                    +$hash['alloted']['application_cost'] 
                    +$hash['sell']['application_cost'],
                'content' => $hash['principal']['content']??'',
            );
            $arr1['subtitle'] = $arr1['excitation'] + $arr1['commission1'] + $arr1['commission2'];
            $arr1['reservations'] = ($arr1['codes']==$arr1['uuid'])?0:$arr1['subtitle']/10;
            $arr1['commission'] = $arr1['subtitle']-$arr1['reservations'];
            $result[] = $arr1;
        }
        return [
            'data'=>$result,
            'ae'=>$AE,
            'group'=>AeCommissionSummary::select()
                ->selectRaw(sprintf("(select sum(transaction_number_correction)*50 from ae_commission_summary where datediff(buss_date,'%s')<=0 and cate='group_info') as total_group_open",$month))
                ->selectRaw(sprintf("(select sum(ae_application_cost_correction) from ae_commission_summary where datediff(buss_date,'%s')<=0 and cate='group_info') as total_group_commission",$month))
                ->where('ae_codes','=','group_info')->where('buss_date','=',$month)->first(),
        ];
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
            foreach(['application_fee','bonus_application','application_cost','ae_application_cost','transaction_number'] as $j){
                $arr[$i][$j] = 0;
                $arr[$i][$j.'_correction'] = 0;
            }
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
            'end_date' => Carbon::parse($month)->endOfMonth()->format('Y-m-d'),
            'accumulated_provision'=>AeCommissionSummary::where('ae_codes','=',$AE['codes'])->where('cate','=','reserve')->whereDate('buss_date','<',$month)->sum('bonus_application_correction'),
        ],$hash);
        $result['subtitle'] = ($result['principal']['bonus_application_correction']??$result['principal']['bonus_application'])
            + ($result['fee']['bonus_application_correction']??$result['fee']['bonus_application'])
            + ($result['interest']['bonus_application_correction']??$result['interest']['bonus_application'])
            + ($result['alloted']['bonus_application_correction']??$result['alloted']['bonus_application'])
            + ($result['fee']['ae_application_cost_correction']??$result['fee']['ae_application_cost'])
            + ($result['interest']['ae_application_cost_correction']??$result['interest']['ae_application_cost'])
            + ($result['sell']['bonus_application_correction']??$result['sell']['bonus_application'])
            + ($result['accumulated_provision']);
        //$result['reservations'] = $result['subtitle']/10;
        //$result['commission'] = $result['subtitle']-$result['reservations'];
        return $result;
    }

    public function detail(Request $request){
        $input = $request->only('uuid','month','cate','product_id','client_acc_id','dummy');
        $AE = AE::select('name')
            ->selectRaw("group_concat(code) as codes")
            ->where('uuid','=',$input['uuid'])
            ->groupBy('uuid','name')
            ->first()->toArray();
        if($AE['name']=='梧桐花開'){
            $AE['name']='王浩進';
            $AE['codes'] = $AE['codes'].',AEWHC';
        }
        $TempClientBonusWithDummy = DB::query()->fromSub(function($query) use($AE,$input){
            $query->from('tt_client_bonus_with_dummy')->select('tt_client_bonus_with_dummy.ae_code','buss_date','allot_date','tt_client_bonus_with_dummy.client_acc_id','name','phone','product_id','application_fee','application_cost','accumulate_performance','seq','dummy','bonus_application1')
            ->selectRaw("case cate when 'principal' then '開戶激勵＿專戶' when 'fee08' then '申購手續費_現金戶' when 'fee13' then '申購手續費_專戶' when 'interest08' then '利息收支_現金戶' when 'interest13' then '利息收支_專戶' when 'alloted08' then '中籤收入_現金戶' when 'alloted13' then '中籤收入_專戶' when 'sell08' then '二級市場收入_現金戶' when 'sell13' then '二級市場收入_專戶' end as cate")
            ->whereIn('tt_client_bonus_with_dummy.ae_code',explode(',',$AE['codes']))
            ->whereDate('allot_date','>=',$input['month'])
            ->whereDate('allot_date','<=',Carbon::parse($input['month'])->endOfMonth()->format('Y-m-d'))
            ->whereNotIn('tt_client_bonus_with_dummy.client_acc_id',['20000113','20000313'])
            ->leftJoin('cysislb_gts_client_acc','cysislb_gts_client_acc.client_acc_id','=','tt_client_bonus_with_dummy.client_acc_id');
        },'t')->select();
        foreach(['cate','product_id','client_acc_id','dummy'] as $item){
            if($request->has($item)) if($input[$item]!='') $TempClientBonusWithDummy->where($item,'=',$input[$item]);
        }
        return [
            'month'=>$input['month'],
            'ae'=>$AE['name'],
            'data'=>$TempClientBonusWithDummy->get()
        ];
    }
    public function detailCsv(Request $request){
        extract($this->detail($request));
        return (new CommissionDetail($data))->download($month.$ae.'佣金明細.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function detailPdf(Request $request){
        $pdf = PDF::loadView('pdf.AeCommissionDetailForm', array_merge(
            $this->detail($request),
            $this->StylingImages()
        ));
        $pdf->setOptions(['isPhpEnabled' => true]);
        return $pdf->stream('AeCommissionDetailForm.pdf');
    }
    public function PaymentRequestForm(string $uuid, Request $request){
        $input = $request->only('month');

        $pdf = PDF::loadView('pdf.PaymentRequestForm', array_merge(
            $this->aeConfirmData($uuid,$input['month']),
            $this->StylingImages(),
        ));
        $pdf->setOptions(['isPhpEnabled' => true]);
        return $pdf->stream('PaymentRequestForm.pdf');
    }

    public function recalculate(Request $request){
        $input = $request->only('month');
        Artisan::call('Commission:Recalculate',['month'=>$input['month'].'-01']);
        return ['ok'=>true];
    }
}
