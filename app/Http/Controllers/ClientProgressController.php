<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClientProgressController extends HomeController
{
    protected $name = 'ClientProgress';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $columns = [
            ['key' => 'AE', 'sortable' => true],
            ['key' => '客户姓名', 'sortable' => true],
            ['key' => '證件號碼', 'sortable' => true],
            ['key' => '手機號碼', 'sortable' => true],
            ['key' => '流程', 'sortable' => true],
            ['key' => '開戶進度', 'sortable' => true],
            ['key' => '狀態', 'sortable' => true],
            ['key' => '郵箱', 'sortable' => true],
            ['key' => '更新時間', 'sortable' => true],
        ];
        $FilterType = [
            'AE' => 'equals',
            '客户姓名' => 'startsWith',
            '證件號碼' => 'startsWith',
            '手機號碼' => 'startsWith',
            '流程' => 'equals',
            '開戶進度' => 'equals',
            '狀態' => 'equals',
            '郵箱' => 'startsWith',
            '更新時間' => 'betweenDate',
        ];
        $parameters['columns'] = json_encode($columns);
        $parameters['FilterType'] = json_encode($FilterType);
        return $parameters;
    }

    public function query(Request $request)
    {
        $Clients = Client::with(['ViewIntroducer', 'IDCard', 'EditableSteps' => function ($query) {
            $query->where('reason', 'correction');
        }])
            ->where('type', '拼一手')
            ->where(function (Builder $query) use ($request) {
                $query->whereHasMorph('IDCard', [
                    ClientCNIDCard::class,
                    ClientHKIDCard::class,
                    ClientOtherIDCard::class,
                ], function (Builder $query) use ($request) {
                    if ($request->filled('客户姓名')) {
                        $query = $query->where('name_c', 'like', $request->input('客户姓名') . '%');
                    }
                    if ($request->filled('證件號碼')) {
                        $query = $query->where('idcard_no', 'like', $request->input('證件號碼') . '%');
                    }
                });
                if ($request->filled('手機號碼')) {
                    $query = $query->where('mobile', 'like', $request->input('手機號碼') . '%');
                }
                if ($request->filled('郵箱')) {
                    $query = $query->where('email', 'like', $request->input('郵箱') . '%');
                }
                if ($request->filled('AE')) {
                    $query = $query->whereHas('ViewIntroducer', function (Builder $query) use ($request) {
                        $query->where('name', $request->input('AE'));
                    });
                }
                if ($request->filled('由更新時間') && $request->filled('至更新時間')) {
                    $query = $query->whereBetween('updated_at', [$request->input('由更新時間'), $request->input('至更新時間')]);
                }
            })->get();
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $row['AE'] = $Client->ViewIntroducer->ae_name;
            $row['客户姓名'] = is_object($Client->IDCard) ? $Client->IDCard->name_c : null;
            $row['證件號碼'] = is_object($Client->IDCard) ? $Client->IDCard->idcard_no : null;
            $row['手機號碼'] = $Client->mobile;
            if ($Client->selected_flow) {
                $selected_flow = json_decode($Client->selected_flow, true);
                if ($selected_flow[1] == 'zh-hk') {
                    $流程 = '香港';
                } elseif ($selected_flow[1] == 'others') {
                    $流程 = '其他地區';
                } elseif ($selected_flow[1] == 'zh-cn') {
                    if (array_key_exists(2, $selected_flow)) {
                        if ($selected_flow[2] == 'WithHKBankCard') {
                            $流程 = '中國(香港銀行卡)';
                        } elseif ($selected_flow[2] == 'WithOtherBankCard') {
                            $流程 = '中國(其他地區銀行卡)';
                        }
                    } else {
                        $流程 = '中國';
                    }
                }
                $selected_flow = implode('.', $selected_flow);
                $max_progress = intval(config("progress.MaxProgress.$selected_flow"));
            } else {
                $流程 = null;
                $max_progress = '?';
            }
            $row['流程'] = $流程;
            $row['開戶進度'] = "$Client->progress/$max_progress";
            if (count($Client->EditableSteps) > 0) {
                $row['狀態'] = 'rejected';
            } else {
                $row['狀態'] = $Client->status;
            }
            $row['郵箱'] = $Client->email;
            $row['更新時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $rows[] = $row;
        }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function getData(Request $request)
    {
        $Clients = Client::with(['ViewIntroducer', 'IDCard'])
            ->whereDoesntHave('AyersAccounts')
            ->where('type', '拼一手')
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        $rows = [];
        foreach ($Clients as $Client) {
            $row = [];
            $row['AE'] = $Client->ViewIntroducer->ae_name;
            $row['客户姓名'] = is_object($Client->IDCard) ? $Client->IDCard->name_c : null;
            $row['證件號碼'] = is_object($Client->IDCard) ? $Client->IDCard->idcard_no : null;
            $row['手機號碼'] = $Client->mobile;
            if ($Client->selected_flow) {
                $selected_flow = json_decode($Client->selected_flow, true);
                if ($selected_flow[1] == 'zh-hk') {
                    $流程 = '香港';
                } elseif ($selected_flow[1] == 'others') {
                    $流程 = '其他地區';
                } elseif ($selected_flow[1] == 'zh-cn') {
                    if (array_key_exists(2, $selected_flow)) {
                        if ($selected_flow[2] == 'WithHKBankCard') {
                            $流程 = '中國(香港銀行卡)';
                        } elseif ($selected_flow[2] == 'WithOtherBankCard') {
                            $流程 = '中國(其他地區銀行卡)';
                        }
                    } else {
                        $流程 = '中國';
                    }
                }
                $selected_flow = implode('.', $selected_flow);
                $max_progress = intval(config("progress.MaxProgress.$selected_flow"));
            } else {
                $流程 = null;
                $max_progress = '?';
            }
            $row['流程'] = $流程;
            $row['開戶進度'] = "$Client->progress/$max_progress";
            $row['郵箱'] = $Client->email;
            $row['更新時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $rows[] = $row;
        }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
    }
}
