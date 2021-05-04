<?php

namespace App\Http\Controllers;

use App\Imports\A07Import;
use Excel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
                'key' => "開戶處理",
                'label' => "開戶處理",
                'icon' => "pi pi-fw pi-file",
                'items' => [
                    [
                        'label' => "一審資料未審核清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('UnauditedList1'),
                    ],
                    [
                        'label' => "一審資料再審核清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('ReauditList1'),
                    ],
                    [
                        'label' => "資料駁回清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('RejectedList1'),
                    ],
                    [
                        'label' => "二審資料未審核清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('UnauditedList2'),
                    ],
                    [
                        'label' => "二審資料可投遞清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('DeliverableList2'),
                    ],
                    [
                        'label' => "開戶信發送清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('SendingEmailList'),
                    ],
                    [
                        'label' => "年度通知書發送清單",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                ],
            ],
            [
                'label' => "帳戶查詢",
                'icon' => "pi pi-fw pi-search",
                'items' => [
                    [
                        'label' => "駁回帳戶列表",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "失效帳戶列表",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                ],
            ],
            [
                'label' => "帳戶總覽",
                'icon' => "pi pi-fw pi-user",
                'items' => [
                    [
                        'label' => "帳戶資料修改申請",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "客戶存款申請",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('ClientFundInRequests'),
                    ],
                    [
                        'label' => "客戶香港出款申請",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('ClientHKFundOutRequests'),
                    ],
                    [
                        'label' => "客戶海外出款申請",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "客戶內部轉帳申請",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "帳戶銷戶申請",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "銀盛信用卡出款申請",
                        'icon' => "pi pi-fw pi-caret-right",
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
        return ['menu' => json_encode($this->getMenu())];
    }

    public function testCSVImport(Request $request)
    {
        Excel::import(new A07Import, 'D:\银盛证券\Ayers\202104\20210422\Client_Interest_Statement_CSV07_20210422.csv');
    }

}
