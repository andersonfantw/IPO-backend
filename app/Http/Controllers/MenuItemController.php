<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\RoleMenuItem;
use App\UserRole;
use Illuminate\Http\Request;
use App\Traits\Query;

class MenuItemController extends Controller
{
    use Query;

    private $menus;

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
                        'url' => 'Permission',
                    ],
                ],
            ],
            [
                'label' => "開戶處理",
                'items' => [
                    [
                        'label' => "查看開戶進度",
                        'url' => 'ClientProgress',
                    ],
                    [
                        'label' => "一審資料未審核清單",
                        'url' => 'UnauditedList1',
                    ],
                    [
                        'label' => "一審資料再審核清單",
                        'url' => 'ReauditList1',
                    ],
                    [
                        'label' => "資料駁回清單",
                        'url' => 'RejectedList1',
                    ],
                    [
                        'label' => "二審資料未審核清單",
                        'url' => 'UnauditedList2',
                    ],
                    [
                        'label' => "二審資料可投遞清單",
                        'url' => 'DeliverableList2',
                    ],
                    [
                        'label' => "開戶信發送清單",
                        'url' => 'SendingEmailList',
                    ],
                    [
                        'label' => "年度通知書發送清單",
                        'url' => 'AccountReportSendingSummary',
                    ],
                ],
            ],
            [
                'label' => "通知發出記錄",
                'items' => [
                    [
                        'label' => "通知發出記錄",
                        'url' => 'NotificationSummary',
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
                        'url' => 'ClientBankCards',
                    ],
                    [
                        'label' => "添加信用卡申請",
                        'url' => 'ClientCreditCards',
                    ],
                ],
            ],
            [
                'label' => "客戶出入金申請",
                'items' => [
                    [
                        'label' => "存款申請",
                        'url' => 'ClientFundInRequests',
                    ],
                    [
                        'label' => "香港出款申請",
                        'url' => 'ClientHKFundOutRequests',
                    ],
                    [
                        'label' => "海外出款申請",
                        'url' => 'ClientOverseasFundOutRequests',
                    ],
                    [
                        'label' => "內部轉帳申請",
                        'url' => 'ClientFundInternalTransferRequests',
                    ],
                    [
                        'label' => "銀盛信用卡出款申請",
                        'url' => 'ClientCreditCardFundOutRequests',
                    ],
                ],
            ],
            [
                'label' => "AE佣金",
                'items' => [
                    [
                        'label' => "佣金總覽",
                        'url' => 'AeCommissionSummary',
                    ],
                ],
            ],
            [
                'label' => "帳戶資料修改申請",
                'items' => [
                    [
                        'label' => "住址證明修改申請",
                        'url' => 'ClientDataUpdate',
                    ],
                ],
            ],
            [
                'label' => "財務",
                'items' => [
                    [
                        'label' => "核對入款記錄",
                        'url' => 'CheckingDeposit',
                    ],
                ],
            ],
        ];
    }

    public function getCounts()
    {

        $Counts = $this->getUnauditedList1Query()
            ->selectRaw("'一審資料未審核清單' as name")
            ->selectRaw('count(*) as count')->union(
                $this->getReauditList1Query()
                    ->selectRaw("'一審資料再審核清單' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getRejectedList1Query()
                    ->selectRaw("'資料駁回清單' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getUnauditedList2Query()
                    ->selectRaw("'二審資料未審核清單' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getDeliverableList2Query()
                    ->whereDoesntHave('AyersAccounts')
                    ->selectRaw("'二審資料可投遞清單' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getSendingEmailListQuery()
                    ->selectRaw("'開戶信發送清單' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getClientBankCardsQuery()
                    ->where('status', 'pending')
                    ->selectRaw("'添加銀行卡申請' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getClientFundInRequestsQuery()
                    ->where('status', 'pending')
                    ->selectRaw("'存款申請' as name")
                    ->selectRaw('count(*) as count')
            )->union(
                $this->getClientHKFundOutRequestsQuery()
                    ->where('status', 'pending')
                    ->selectRaw("'香港出款申請' as name")
                    ->selectRaw('count(*) as count')
            )->get()->toArray();
        return $Counts;
        // $CountUnauditedList1 = $this->getUnauditedList1Query()->count();
        // $CountReauditList1 = $this->getReauditList1Query()->count();
        // $CountRejectedList1 = $this->getRejectedList1Query()->count();
        // $CountUnauditedList2 = $this->getUnauditedList2Query()->count();
        // $CountDeliverableList2 = $this->getDeliverableList2Query()->whereDoesntHave('AyersAccounts')->count();
        // $CountSendingEmailList = $this->getSendingEmailListQuery()->count();
        // $CountClientBankCards = $this->getClientBankCardsQuery()->count();
        // $CountClientFundInRequests = $this->getClientFundInRequestsQuery()
        //     ->where('status', 'pending')
        //     ->count();
        // $CountClientHKFundOutRequests = $this->getClientHKFundOutRequestsQuery()
        //     ->where('status', 'pending')
        //     ->count();
        // return json_encode([
        //     'CountUnauditedList1' => $CountUnauditedList1,
        //     'CountReauditList1' => $CountReauditList1,
        //     'CountRejectedList1' => $CountRejectedList1,
        //     'CountUnauditedList2' => $CountUnauditedList2,
        //     'CountDeliverableList2' => $CountDeliverableList2,
        //     'CountSendingEmailList' => $CountSendingEmailList,
        //     'CountClientBankCards' => $CountClientBankCards,
        //     'CountClientFundInRequests' => $CountClientFundInRequests,
        //     'CountClientHKFundOutRequests' => $CountClientHKFundOutRequests,
        // ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $UserRoles = UserRole::where('user_id', $user_id)->get();
        $menu_items = [];
        // $UserRoles = auth()->user()->UserRole;
        foreach ($UserRoles as $UserRole) {
            $RoleMenuItems = $UserRole->Role->RoleMenuItem;
            foreach ($RoleMenuItems as $RoleMenuItem) {
                $menu_items[] = $RoleMenuItem->MenuItem->name;
            }
        }
        $filtered_menus = [];
        foreach ($this->menus as $menu) {
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
        // return [
        //     'menu' => json_encode($filtered_menus, JSON_UNESCAPED_UNICODE),
        // ];
        return $filtered_menus;
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
        MenuItem::create([
            'name' => $request->input('name'),
        ]);
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
        MenuItem::destroy($id);
        RoleMenuItem::where('menu_item_id', $id)->delete();
    }
}
