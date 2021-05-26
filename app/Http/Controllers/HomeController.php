<?php

namespace App\Http\Controllers;

use App\Imports\A07Import;
use App\Traits\CountRecords;
use Excel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use CountRecords;

    protected $name = 'Home';
    private $menu;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->menu = [
            [
                'label' => "開戶處理",
                'items' => [
                    [
                        'label' => "一審資料未審核清單",
                        'url' => route('UnauditedList1'),
                        'no_of_news' => $this->countNewUnauditedClients1(),
                    ],
                    [
                        'label' => "一審資料再審核清單",
                        'url' => route('ReauditList1'),
                        'no_of_news' => $this->countNewReauditClients(),
                    ],
                    [
                        'label' => "資料駁回清單",
                        'url' => route('RejectedList1'),
                        'no_of_news' => $this->countNewRejectedClients1(),
                    ],
                    [
                        'label' => "二審資料未審核清單",
                        'url' => route('UnauditedList2'),
                        'no_of_news' => $this->countNewUnauditedClients2(),
                    ],
                    [
                        'label' => "二審資料可投遞清單",
                        'url' => route('DeliverableList2'),
                        'no_of_news' => $this->countNewDeliverableClients(),
                    ],
                    [
                        'label' => "開戶信發送清單",
                        'url' => route('SendingEmailList'),
                        'no_of_news' => $this->countNewSendingEmailClients(),
                    ],
                    [
                        'label' => "年度通知書發送清單",
                    ],
                ],
            ],
            [
                'label' => "帳戶查詢",
                'items' => [
                    [
                        'label' => "駁回帳戶列表",
                    ],
                    [
                        'label' => "失效帳戶列表",
                    ],
                ],
            ],
            [
                'label' => "帳戶總覽",
                'items' => [
                    [
                        'label' => "帳戶資料修改申請",
                    ],
                    [
                        'label' => "帳戶銷戶申請",
                    ],
                ],
            ],
            [
                'label' => " 客戶出入金申請",
                'items' => [
                    [
                        'label' => "存款申請",
                        'url' => route('ClientFundInRequests'),
                        'no_of_news' => $this->countNewClientFundInRequests(),
                    ],
                    [
                        'label' => "香港出款申請",
                        'url' => route('ClientHKFundOutRequests'),
                        'no_of_news' => $this->countNewClientHKFundOutRequests(),
                    ],
                    [
                        'label' => "海外出款申請",
                        'url' => route('ClientOverseasFundOutRequests'),
                        'no_of_news' => $this->countNewClientOverseasFundOutRequests(),
                    ],
                    [
                        'label' => "內部轉帳申請",
                        'url' => route('ClientFundInternalTransferRequests'),
                        'no_of_news' => $this->countNewClientFundInternalTransferRequests(),
                    ],
                    [
                        'label' => "銀盛信用卡出款申請",
                        'url' => route('ClientCreditCardFundOutRequests'),
                        'no_of_news' => $this->countNewClientCreditCardFundOutRequests(),
                    ],
                ],
            ],
        ];
    }

    protected function getMenu()
    {
        return $this->menu;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view($this->name, $this->setViewParameters($request));
    }

    protected function setViewParameters(Request $request)
    {
        return [
            'menu' => json_encode($this->getMenu(), JSON_UNESCAPED_UNICODE),
        ];
    }

    public function testCSVImport(Request $request)
    {
        Excel::import(new A07Import, 'D:\银盛证券\Ayers\202104\20210422\Client_Interest_Statement_CSV07_20210422.csv');
    }

}
