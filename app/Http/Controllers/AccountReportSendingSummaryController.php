<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AuthorizedUserRequest;
use App\Http\Requests\AccountReportSendingSummaryFormRequest;
use App\AccountReportSendingSummary;
use App\AccountReport;
use App\CysislbGtsClientAcc;

class AccountReportSendingSummaryController extends HomeController
{
    protected $name = 'AccountReportSendingSummary';

    public function indexView(Request $request){
        return parent::index($request);
    }
    public function index(Request $request){
        // return DB::query()->fromSub(function($query){
        //     $query->fromSub(function($query){
        //         $query->from('account_reports')
        //             ->select('account_report_sending_summary_id','sending_status')
        //             ->selectRaw('count(*) as num')
        //             ->groupBy('account_report_sending_summary_id','sending_status');
        //     })->select('account_report_sending_summary_id')
        //     ->selectRaw("sum(IF(sending_status is null, num, 0)) AS nulls")
        //     ->selectRaw("sum(IF(sending_status='fail', num, 0)) AS failure")
        //     ->selectRaw("sum(IF(sending_status='success', num, 0)) AS success")
        //     ->selectRaw("sum(IF(sending_status='pending', num, 0)) AS pending")
        //     ->groupBy('account_report_sending_summary_id');
        // })->select('id','ipo_activity_period_id','start_date','end_date','report_make_date','performance_fee_date','report')
        // ->select('nulls','failure','success','pending')
        // ->selectRaw("concat(format((failure+success)/(nulls+failure+success+pending)*100,2),'%') as sending_progress")
        // ->selectRaw('nulls+failure+success+pending as total')
        // ->get()->toArray();

        $AccountReport = DB::query()->select('account_report_sending_summary_id','nulls','failure','success','pending')
            ->selectRaw("concat(format((failure+success)/(nulls+failure+success+pending)*100,2),'%') as sending_progress")
            ->selectRaw('nulls+failure+success+pending as total')
            ->fromSub(function($query){
            $query->fromSub(function($query){
                $query->from('account_reports')
                    ->select('account_report_sending_summary_id','sending_status')
                    ->selectRaw('count(*) as num')
                    ->groupBy('account_report_sending_summary_id','sending_status');
            },'t')->select('account_report_sending_summary_id')
            ->selectRaw("sum(IF(sending_status is null, num, 0)) AS nulls")
            ->selectRaw("sum(IF(sending_status='fail', num, 0)) AS failure")
            ->selectRaw("sum(IF(sending_status='success', num, 0)) AS success")
            ->selectRaw("sum(IF(sending_status='pending', num, 0)) AS pending")
            ->groupBy('account_report_sending_summary_id');
        },'t1')->get()->toArray();

        $AccountReportSendingSummary = AccountReportSendingSummary::select('id','ipo_activity_period_id','start_date','end_date','report_make_date','performance_fee_date','report')->get();

        $hash = [];
        foreach($AccountReportSendingSummary as $row) $hash[$row->id] = $row;
        unset($AccountReportSendingSummary);

        return array_map(function($row) use($hash){
            return [
                'id' => $row->account_report_sending_summary_id,
                'data' => $hash[$row->account_report_sending_summary_id],
                'total' => $row->total,
                'sending_progress' => $row->sending_progress,
                'success' => $row->success,
                'failure' => $row->failure,
            ];;
        },$AccountReport);
    }
    public function store(AccountReportSendingSummaryFormRequest $request){
        $AccountReportSendingSummary = AccountReportSendingSummary::create(
            $request->only(AccountReportSendingSummaryFormRequest::field_names)
        );
        $CysislbGtsClientAcc = CysislbGtsClientAcc::whereRaw("substr(client_acc_id,-2,2)='13'")->active()->get();
        foreach($CysislbGtsClientAcc->chunk(500) as $rows){
            AccountReport::Upsert(array_map(function($row) use($AccountReportSendingSummary){
                return [
                    'account_report_sending_summary_id' => $AccountReportSendingSummary->id,
                    'client_acc_id' => $row['client_acc_id'],
                ];
            },$rows->toArray()),['account_report_sending_summary_id','client_acc_id'],[]);
        }
        return ['ok'=>true];
    }
    public function update(AccountReportSendingSummaryFormRequest $request, $id){
        if(empty($id)) abort('404');
        $input = $request->only(AccountReportSendingSummaryFormRequest::field_names);
        AccountReportSendingSummary::findOrFail($id)->update($input);
        return ['ok'=>true];
    }
    public function destroy($id){
        AccountReport::ofParentID($id)->delete();
        AccountReportSendingSummary::destroy($id);
        return ['ok'=>true];
    }

    // for /AccountReportSendingSummary/{id}
    public function show($id)
    {
        return view('AccountReport', array_merge($this->setViewParameters(new Request),['id'=>$id]));
    }
}
