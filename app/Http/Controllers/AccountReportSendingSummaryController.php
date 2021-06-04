<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthorizedUserRequest;
use App\Http\Requests\AccountReportSendingSummaryFormRequest;
use App\AccountReportSendingSummary;

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
                'total' => '',
                'sending_progress' => '',
                'success' => '',
                'failure' => '',
            ];
        },AccountReportSendingSummary::select('id','ipo_activity_period_id','start_date','end_date','report_make_date','report')->get()->toArray());
    }
    public function store(AccountReportSendingSummaryFormRequest $request){
        AccountReportSendingSummary::create(
            $request->only(AccountReportSendingSummaryFormRequest::field_names)
        );
        AccountReport::Upsert();
        return ['ok'=>true];
    }
    public function update(AccountReportSendingSummaryFormRequest $request){
        if(!$request->filled('id')) abort('404');
        $id = $request->input('id');
        $input = $request->only(AccountReportSendingSummaryFormRequest::field_names);
        AccountReportSendingSummary::findOrFail($id)->update($input);
        return ['ok'=>true];
    }
    public function destroy($id){
        $AccountReportSendingSummary = AccountReportSendingSummary::find($id);
        return ['ok'=>true];
    }

    // for /AccountReportSendingSummary/{id}
    public function show(Request $request)
    {
        return view('AccountReport', $this->setViewParameters($request));
    }
}
