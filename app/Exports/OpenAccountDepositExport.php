<?php

namespace App\Exports;

use App\ClientDepositProof;
use App\Client;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;

class OpenAccountDepositExport extends AyersValueBinder implements FromView
{
    private $clients;

    private $Headers;

    public function __construct(array $clients)
    {
        $this->clients = $clients;
        $this->Headers = ['tran_date', 'client_acc_id', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
    }

    public function view(): View
    {
        $uuids = [];
        foreach ($this->clients as $client) {
            $uuids[] = $client['uuid'];
        }
        $Clients = Client::with(['ClientDepositProof', 'AyersAccounts' => function ($query) {
            $query->where('account_no', 'like', '%08');
        }, 'DepositIdentificationCode.UnknownDeposit'])->whereIn('uuid', $uuids)->get();
        $OpenAccountDeposits = [];
        foreach ($Clients as $Client) {
            $AyersAccount = $Client->AyersAccounts->first();
            if (!is_object($Client->ClientDepositProof) || !is_object($AyersAccount)) {
                continue;
            }
            $now = Carbon::now();
            $OpenAccountDeposit['tran_date'] = "{$now->day}/{$now->month}/{$now->year}";
            $OpenAccountDeposit['client_acc_id'] = $AyersAccount->account_no;
            $OpenAccountDeposit['ccy'] = 'HKD';
            $OpenAccountDeposit['amount'] = $Client->ClientDepositProof->deposit_amount;
            if (is_object($Client->DepositIdentificationCode) && is_object($Client->DepositIdentificationCode->UnknownDeposit->first())) {
                $UnknownDeposit = $Client->DepositIdentificationCode->UnknownDeposit->first();
                $dt = Carbon::parse($Client->ClientDepositProof->transfer_time);
                // $transaction_date = Carbon::parse($UnknownDeposit->transaction_date)->toDateString();
                $OpenAccountDeposit['remark'] = "PRINCIPAL IN_" . $dt->format('Ymd');
            } else {
                $OpenAccountDeposit['remark'] = "PRINCIPAL IN";
            }
            $OpenAccountDeposit['gl_mapping_item_id'] = null;
            $OpenAccountDeposit['bank_acc_id'] = "{$Client->ClientDepositProof->deposit_bank}:HKD:{$Client->ClientDepositProof->deposit_bank_account}";
            $OpenAccountDeposit['cheque'] = null;
            $OpenAccountDeposits[] = $OpenAccountDeposit;
        }
        return view('excel.OpenAccountDepositExport', [
            'Headers' => $this->Headers,
            'OpenAccountDeposits' => $OpenAccountDeposits,
        ]);
    }
}
