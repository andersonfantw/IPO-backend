<?php

namespace App\Exports;

use App\ClientDepositProof;
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
        $this->Headers = ['tran_date', 'ccclnId', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
    }

    public function view(): View
    {
        $uuids = [];
        foreach ($this->clients as $client) {
            $uuids[] = $client['uuid'];
        }
        $OpenAccountDeposits = [];
        $ClientDepositProofs = ClientDepositProof::whereIn('uuid', $uuids)->get();
        foreach ($ClientDepositProofs as $ClientDepositProof) {
            $OpenAccountDeposit['tran_date'] = Carbon::parse($ClientDepositProof->transfer_time)->format('d/m/Y');
            $OpenAccountDeposit['ccclnId'] = '';
            $OpenAccountDeposit['ccy'] = 'HKD';
            $OpenAccountDeposit['amount'] = $ClientDepositProof->deposit_amount;
            $OpenAccountDeposit['remark'] = 'PRINCIPAL IN';
            $OpenAccountDeposit['gl_mapping_item_id'] = null;
        }
    }
}
