<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
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
                'key' => "业务处理",
                'label' => "业务处理",
                'icon' => "pi pi-fw pi-file",
                'items' => [
                    [
                        'label' => "一审资料未审核清单",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('UnauditedDataList1'),
                    ],
                    [
                        'label' => "一审资料再审核清单",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "一审资料驳回清单",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "二审资料未审核清单",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "二审资料可投递清单",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "开户信发送清单",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "年度通知书发送清单",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                ],
            ],
            [
                'label' => "业务查询",
                'icon' => "pi pi-fw pi-search",
                'items' => [
                    [
                        'label' => "驳回用户列表",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                    [
                        'label' => "失效用户列表",
                        'icon' => "pi pi-fw pi-caret-right",
                    ],
                ],
            ],
            [
                'label' => "用户系统",
                'icon' => "pi pi-fw pi-user",
                'items' => [
                    [
                        'label' => "推荐关系",
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
    public function main(Request $request)
    {
        return view('home', ['menu' => json_encode($this->menu)]);
    }

}
