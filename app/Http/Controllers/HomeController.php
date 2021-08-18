<?php

namespace App\Http\Controllers;

use App\Imports\A07Import;
use App\Traits\CountRecords;
use App\Traits\Image;
use Excel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use CountRecords, Image;

    protected $name = 'Home';
    private $menus;
    private $acl;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->menus = [
            [
                'label' => "中台使用者",
                'items' => [
                    [
                        'label' => "權限管理",
                        'url' => secure_url('Permission'),
                    ],
                ],
            ],
            [
                'label' => "開戶處理",
                'items' => [
                    [
                        'label' => "查看開戶進度",
                        'url' => route('ClientProgress'),
                    ],
                    [
                        'label' => "一審資料未審核清單",
                        'url' => route('UnauditedList1'),
                    ],
                    [
                        'label' => "一審資料再審核清單",
                        'url' => route('ReauditList1'),
                    ],
                    [
                        'label' => "資料駁回清單",
                        'url' => route('RejectedList1'),
                    ],
                    [
                        'label' => "二審資料未審核清單",
                        'url' => route('UnauditedList2'),
                    ],
                    [
                        'label' => "二審資料可投遞清單",
                        'url' => route('DeliverableList2'),
                    ],
                    [
                        'label' => "開戶信發送清單",
                        'url' => route('SendingEmailList'),
                    ],
                    [
                        'label' => "年度通知書發送清單",
                        'url' => route('AccountReportSendingSummary'),
                    ],
                ],
            ],
            [
                'label' => "通知發出記錄",
                'items' => [
                    [
                        'label' => "通知發出記錄",
                        'url' => route('NotificationSummary'),
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
                    [
                        'label' => "添加銀行卡申請",
                        'url' => route('ClientBankCards'),
                    ],
                    [
                        'label' => "添加信用卡申請",
                        'url' => route('ClientCreditCards'),
                    ],
                ],
            ],
            [
                'label' => "客戶出入金申請",
                'items' => [
                    [
                        'label' => "存款申請",
                        'url' => route('ClientFundInRequests'),
                    ],
                    [
                        'label' => "香港出款申請",
                        'url' => route('ClientHKFundOutRequests'),
                    ],
                    [
                        'label' => "海外出款申請",
                        'url' => route('ClientOverseasFundOutRequests'),
                    ],
                    [
                        'label' => "內部轉帳申請",
                        'url' => route('ClientFundInternalTransferRequests'),
                    ],
                    [
                        'label' => "銀盛信用卡出款申請",
                        'url' => route('ClientCreditCardFundOutRequests'),
                    ],
                ],
            ],
            [
                'label' => "帳戶資料修改申請",
                'items' => [
                    [
                        'label' => "住址證明修改申請",
                        'url' => route('ClientAddressProofUpdates'),
                    ],
                ],
            ],
        ];
    }

    protected function getMenus()
    {
        return $this->menus;
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
        $menu_items = [];
        $UserRoles = auth()->user()->UserRole;
        foreach ($UserRoles as $UserRole) {
            $Role = $UserRole->Role;
            $RoleMenuItems = $Role->RoleMenuItem;
            foreach ($RoleMenuItems as $RoleMenuItem) {
                $menu_items[] = $RoleMenuItem->MenuItem->name;
            }
        }
        $filtered_menus = [];
        foreach ($this->getMenus() as $menu) {
            $filtered_items = [];
            foreach ($menu['items'] as $item) {
                if (in_array($item['label'], $menu_items)) {
                    $filtered_items[] = $item;
                }
            }
            if (!empty($filtered_items)) {
                $filtered_menus[] = [
                    'label' => $menu['label'],
                    'items' => $filtered_items,
                ];
            }
        }
        return [
            'menu' => json_encode($filtered_menus, JSON_UNESCAPED_UNICODE),
        ];
    }

    public function testCSVImport(Request $request)
    {
        Excel::import(new A07Import, 'D:\银盛证券\Ayers\202104\20210422\Client_Interest_Statement_CSV07_20210422.csv');
    }

}
