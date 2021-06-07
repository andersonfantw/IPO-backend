<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return array_map(function($row){
            return [
                'id' => $row['id'],
                'data' => $row,
                'total' => AccountReport::where('account_report_sending_summary_id','=',$row['id'])->count(),
                'sending_progress' => '',
                'success' => '',
                'failure' => '',
            ];
        },AccountReportSendingSummary::select('id','ipo_activity_period_id','start_date','end_date','report_make_date','performance_fee_date','report')->get()->toArray());
    }
    public function store(AccountReportSendingSummaryFormRequest $request){
        $AccountReportSendingSummary = AccountReportSendingSummary::create(
            $request->only(AccountReportSendingSummaryFormRequest::field_names)
        );
        CysislbGtsClientAcc::active()->chunk(500, function($rows) use($AccountReportSendingSummary){
            AccountReport::Upsert(array_map(function($row) use($AccountReportSendingSummary){
                return [
                    'account_report_sending_summary_id' => $AccountReportSendingSummary->id,
                    'client_acc_id' => $row['client_acc_id'],
                ];
            },$rows->toArray()),['account_report_sending_summary_id','client_acc_id'],[]);
        });
        return ['ok'=>true];
    }
    public function update(AccountReportSendingSummaryFormRequest $request, $id){
        if(empty($id)) abort('404');
        $input = $request->only(AccountReportSendingSummaryFormRequest::field_names);
        AccountReportSendingSummary::findOrFail($id)->update($input);
var_dump($id,$input);
        return ['ok'=>true];
    }
    public function destroy($id){
        $AccountReportSendingSummary = AccountReportSendingSummary::destroy($id);
        return ['ok'=>true];
    }

    // for /AccountReportSendingSummary/{id}
    public function show($id)
    {
        return view('AccountReport', array_merge($this->setViewParameters(new Request),['id'=>$id]));
    }
}
