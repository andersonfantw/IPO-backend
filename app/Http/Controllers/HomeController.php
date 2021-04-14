<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $name = 'home';
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
                        'url' => route('UnauditedList1'),
                    ],
                    [
                        'label' => "一审资料再审核清单",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('ReauditList1'),
                    ],
                    [
                        'label' => "资料驳回清单",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('RejectedList1'),
                    ],
                    [
                        'label' => "二审资料未审核清单",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('UnauditedList2'),
                    ],
                    [
                        'label' => "二审资料可投递清单",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('DeliverableList2'),
                    ],
                    [
                        'label' => "開戶信發送清單",
                        'icon' => "pi pi-fw pi-caret-right",
                        'url' => route('SendingEmailList'),
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
    public function index(Request $request)
    {
        return view($this->name, $this->setViewParameters($request));
    }

    protected function setViewParameters(Request $request)
    {
        return ['menu' => json_encode($this->getMenu())];
    }

    protected function sendSMS(Request $request, Client $Client)
    {
        $input = $request->all();
        $country_code = addslashes($input['country_code']);
        $recipient = $Client->mobile;
        $vc = mt_rand(100000, 999999);
        $VerificationCode = VerificationCode::updateOrCreate(
            ['mobile' => $recipient],
            ['code' => $vc, 'expiry_datetime' => date("Y-m-d H:i:s", (time() + 300))]
        );
        $content = "[中國銀盛國際證券]您的手機驗證碼為：{$VerificationCode->code}，驗證碼5分鐘內有效。如非本人操作，請忽略本簡訊。";
        $response = Http::timeout(10)->get(env('HK_SMS_URL'), [
            'langeng' => 0,
            'dos' => 'now',
            'senderid' => 'CYSS',
            'content' => $this->Text2Unicode($content),
            'recipient' => "$country_code$recipient",
            'username' => env('HK_SMS_USERNAME'),
            'password' => env('HK_SMS_PASSWORD'),
        ]);
        return $response;
    }

}
