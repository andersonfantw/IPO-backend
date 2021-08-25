<?php

namespace App\Http\Controllers;

use App\Client;
use App\Traits\Score;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use Score;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Clients = Client::with(['ViewIntroducer', 'IDCard', 'EditableSteps' => function ($query) {
            $query->where('reason', 'correction');
        }, 'AyersAccounts'])
        // ->whereDoesntHave('AyersAccounts')
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
            if (count($Client->EditableSteps) > 0) {
                $row['狀態'] = 'rejected';
            } else {
                $row['狀態'] = $Client->status;
            }
            $AyersAccountNo = [];
            $AyersAccountClosedAt = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersAccountNo[] = $AyersAccount->account_no;
                $AyersAccountClosedAt[] = $AyersAccount->closed_at;
            }
            $row['帳户號碼'] = implode(", ", $AyersAccountNo);
            $row['08銷戶時間'] = count($AyersAccountClosedAt) > 0 ? $AyersAccountClosedAt[0] : null;
            $row['13銷戶時間'] = count($AyersAccountClosedAt) > 1 ? $AyersAccountClosedAt[1] : null;
            $row['郵箱'] = $Client->email;
            $row['更新時間'] = date_format($Client->updated_at, "Y-m-d H:i:s");
            $row['uuid'] = $Client->uuid;
            $row['can_close'] = $Client->can_close;
            $rows[] = $row;
        }
        return json_encode([
            'data' => $rows,
        ], JSON_UNESCAPED_UNICODE);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $details = [];
        $Client = Client::with([
            'IDCard',
            'ClientAddressProof',
            'ClientBankCards',
            'ClientWorkingStatus',
            'ClientFinancialStatus',
            'ClientInvestmentExperience',
            'ViewClientQuestionnaire',
            'ClientEvaluationResults',
            'ClientSignature',
            'ClientBusinessType',
            'ClientDepositProof',
            'ViewIntroducer',
        ])
            ->where('uuid', $uuid)->first();
        $details['uuid'] = $Client->uuid;
        $Client->IDCard->idcard_face = null;
        $Client->IDCard->idcard_back = null;
        $details['ClientIDCard'] = $Client->IDCard->toJson(JSON_UNESCAPED_UNICODE);
        if (is_object($Client->ClientAddressProof)) {
            $Client->ClientAddressProof->image = null;
            $Client->ClientAddressProof->detailed_address = addslashes($Client->ClientAddressProof->detailed_address);
            $details['ClientAddressProof'] = $Client->ClientAddressProof->toJson(JSON_UNESCAPED_UNICODE);
            // $Client->ClientAddressProof->detailed_address = stripslashes($Client->ClientAddressProof->detailed_address);
        } else {
            $details['ClientAddressProof'] = null;
        }
        foreach ($Client->ClientBankCards as &$ClientBankCard) {
            $ClientBankCard->bankcard_blob = null;
        }
        $details['ClientBankCards'] = $Client->ClientBankCards->toJson(JSON_UNESCAPED_UNICODE);
        if ($Client->ClientWorkingStatus->name_card_face) {
            $Client->ClientWorkingStatus->name_card_face = null;
        }
        $details['ClientWorkingStatus'] = $Client->ClientWorkingStatus->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientFinancialStatus->fund_source = addslashes($Client->ClientFinancialStatus->fund_source);
        $details['ClientFinancialStatus'] = $Client->ClientFinancialStatus->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientInvestmentExperience'] = $Client->ClientInvestmentExperience->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientScore'] = json_encode($this->calculateClientScore($Client), JSON_UNESCAPED_UNICODE);
        $details['ClientEvaluationResults'] = $Client->ClientEvaluationResults->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientSignature'] = $Client->ClientSignature->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientBusinessType->direct_promotion = addslashes($Client->ClientBusinessType->direct_promotion);
        $details['ClientBusinessType'] = $Client->ClientBusinessType->toJson(JSON_UNESCAPED_UNICODE);
        if (is_object($Client->ClientDepositProof)) {
            $Client->ClientDepositProof->image = null;
            $details['ClientDepositProof'] = $Client->ClientDepositProof->toJson(JSON_UNESCAPED_UNICODE);
        } else {
            $details['ClientDepositProof'] = null;
        }
        $details['Introducer'] = $Client->ViewIntroducer->toJson(JSON_UNESCAPED_UNICODE);
        $Client = Client::where('uuid', $uuid)->first();
        $Client->idcard_type = addslashes($Client->idcard_type);
        $Client->education_level = addslashes($Client->education_level);
        $Client->selected_flow = addslashes($Client->selected_flow);
        $details['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);
        // $Client->idcard_type = stripslashes($Client->idcard_type);
        return $details;
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
        //
    }
}
