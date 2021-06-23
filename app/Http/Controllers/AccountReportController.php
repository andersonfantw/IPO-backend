<?php

namespace App\Http\Controllers;

use App\AccountReportSendingSummary;
use App\AccountReport;
use App\CysislbGtsClientAcc;
use App\TempIpoSummary;
use App\A01;
use App\A05;
use App\A06;
use App\ViewClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use App\Http\Requests\AccountReportFormRequest;
use Carbon\Carbon;
use PDF;
use App\Traits\Report;
use App\Services\SiteDocumentService;

class AccountReportController extends Controller
{
    use Report;

    protected $name = 'AccountReport';

    public function findClient(Request $request){
        $input = $request->only('acc_no');

        return CysislbGtsClientAcc::select('client_acc_id','name')
        ->where('client_acc_id','like',$input['acc_no'].'%')->get();
    }

    public function store(Request $request, $id){
        $input = $request->only('client_acc_id','client_name');
        $AccountReport = AccountReport::firstOrNew(
            ['client_acc_id'=>$input['client_acc_id']],
            ['account_report_sending_summary_id'=>$id]
        );
        if($AccountReport->exists){
            return ['ok'=>false,'msg'=>sprintf('客戶 %s 編號 %s 已在清單中!',$input['client_name'],$input['client_acc_id'])];
        }else{
            return ['ok'=>true];
        }

    }

    public function index(Request $request, $id){
        $AccountReport = AccountReport::with([
            'ClientInfo' => function($query) use($request){
                $query->select('client_acc_id','name','email');
                $request->whenFilled('name',function($input) use($query){
                    $query->where('name','like','%'.$input.'%');
                });
            }
        ])->ofParentID($id);
        $request->whenFilled('make_report_status', function($input) use ($AccountReport){
            if($input!='all') {
                if ($input == 'null') $AccountReport->whereNull('make_report_status');
                else $AccountReport->where('make_report_status', '=', $input);
            }
        });
        $request->whenFilled('sending_status', function($input) use ($AccountReport){
            if($input!='all') {
                if ($input == 'null') $AccountReport->whereNull('sending_status');
                else $AccountReport->where('sending_status', '=', $input);
            }
        });
        $request->whenFilled('client_acc_id', function($input) use ($AccountReport){
            $AccountReport->where('client_acc_id','like',$input.'%');
        });

        $result = array_merge(
            $AccountReport->paginate(100)->toArray(),
            [
                'buttons' => [
                    'total' => AccountReport::ofParentID($id)->count(),
                    'command' => Queue::size('command'),
                    'pdf' => array_merge(
                        ['null'=>0,'pending'=>0,'success'=>0,'fail'=>0,'queue'=>Queue::size('report')],
                        AccountReport::ofParentID($id)
                        ->select(DB::raw("ifnull(make_report_status,'null') as make_report_status"),DB::raw('count(*) as total'))
                        ->groupBy('make_report_status')->pluck('total','make_report_status')->toArray()
                    ),
                    'email' => array_merge(
                        ['null'=>0,'pending'=>0,'success'=>0,'fail'=>0,'queue'=>Queue::size('email')],
                        AccountReport::ofParentID($id)
                        ->select(DB::raw("ifnull(sending_status,'null') as sending_status"),DB::raw('count(*) as total'))
                        ->groupBy('sending_status')->pluck('total','sending_status')->toArray()
                    ),
                ]
            ]
        );
        return $result;
    }

    // 選擇項目的功能
    public function makePdf(Request $request, $id){
        $input = $request->only('list');
        foreach(explode(',',$input['list']) as $client_acc_id) {
            Artisan::call('AccountReport:MakePdf', [
                'id' => $id,
                '--client' => $client_acc_id
            ]);
        }
        return ['ok'=>true];
    }
    public function sendTestMail(Request $request, $id){
        $input = $request->only('list');
        $i=0;
        foreach(explode(',',$input['list']) as $client_acc_id) {
            Artisan::call('AccountReport:SendTestMail', [
                'id' => $id,
                'client' => $client_acc_id
            ]);
            if($i++>5) break;
        }
        return ['ok'=>true];
    }
    public function sendMail(Request $request, $id){
        $input = $request->only('list');
        foreach(explode(',',$input['list']) as $client_acc_id){
            Artisan::call('AccountReport:send', [
                'id'=>$id,
                '--client'=>$client_acc_id
            ]);
        }
        return ['ok'=>true];
    }
    public function removeClient(Request $request,$id){
        $input = $request->only('list');
        foreach(explode(',',$input['list']) as $client_acc_id){
            AccountReport::ofParentID($id)
            ->where('client_acc_id','=',$client_acc_id)->delete();
        }
        return ['ok'=>true];
    }

    // 全部清單的功能
    public function makeAll(Request $request, $id){
        Artisan::call('AccountReport:MakePdf', ['id'=>$id]);
        return ['ok'=>true];
    }
    public function stopMake(Request $request, $id){
        AccountReport::ofParentID($id)->ofReportStatus('pending')->update(['make_report_status'=>null]);
        Artisan::call('queue:clear', ['name'=>'report']);
        return ['ok'=>true];
    }
    public function clearMake(Request $request, $id){
        AccountReport::ofParentID($id)->update(['report_queue_time'=>null,'make_report_time'=>null,'make_report_status'=>null]);
        return ['ok'=>true];
    }
    public function sendAll(Request $request, $id){
        Artisan::call('AccountReport:send', ['id'=>$id]);
        return ['ok'=>true];
    }
    public function stopSend(Request $request, $id){
        AccountReport::ofParentID($id)->ofSendingStatus('pending')->update(['sending_status'=>null]);
        Artisan::call('queue:clear', ['name'=>'email']);
        return ['ok'=>true];
    }
    public function clearSend(Request $request, $id){
        AccountReport::ofParentID($id)->update(['sending_queue_time'=>null,'sending_time'=>null,'sending_status'=>null]);
        return ['ok'=>true];
    }


    public function showHtml(AccountReportSendingSummary $AccountReportSendingSummary, $client_acc_id, SiteDocumentService $SiteDocumentService){
        return View('pdf.AnnualAccountReport',$SiteDocumentService->AnnualAccountReportData($AccountReportSendingSummary,$client_acc_id));
    }
    public function showPdf(AccountReportSendingSummary $AccountReportSendingSummary, $client_acc_id){
        //$pdf = PDF::loadView('pdf.AnnualAccountReport',(new SiteDocumentService())->AnnualAccountReportData($AccountReportSendingSummary,$client_acc_id));
        //$pdf->setOptions(['isPhpEnabled' => true]);
        $ViewClient = ViewClient::where('account_no','=',$client_acc_id)->firstOrFail();
        return response()->file(
            storage_path('app/').SiteDocumentService::getStoragePath(
                $ViewClient->uuid,
                $AccountReportSendingSummary['report_make_date'],
                $client_acc_id
            )
        );
    }
}
