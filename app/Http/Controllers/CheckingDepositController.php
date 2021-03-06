<?php

namespace App\Http\Controllers;

use App\Imports\UnknownDepositsImport;
use App\Traits\Excel;
use App\UnknownDeposit;
use Carbon\Carbon;
use DB;
use Excel as _Excel;
use Illuminate\Http\Request;

class CheckingDepositController extends Controller
{
    use Excel;

    private $fields = null;
    private $filter_type = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fields = [
            ['key' => 'transaction_date', 'sortable' => true],
            // ['key' => 'value_date', 'sortable' => true],
            ['key' => 'type', 'sortable' => true],
            ['key' => 'identification_code', 'sortable' => true],
            ['key' => 'amount_in', 'sortable' => true],
            ['key' => 'balance', 'sortable' => true],
            ['key' => 'account_no', 'sortable' => true],
            ['key' => 'account_name', 'sortable' => true],
            ['key' => 'status', 'sortable' => true],
            ['key' => 'uploaded_at', 'sortable' => true],
        ];
        $this->filter_type = [
            'transaction_date' => 'betweenDate',
            // 'value_date' => 'betweenDate',
            'type' => 'equals',
            'identification_code' => 'startsWith',
            'amount_in' => 'equals',
            'balance' => 'equals',
            'account_no' => 'startsWith',
            'account_name' => 'betweenDate',
            'status' => 'equals',
            'uploaded_at' => 'betweenDate',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $today = Carbon::today()->toDateString();
        $UnknownDeposits = UnknownDeposit::where('uploaded_at', $request->input('uploaded_at'))
            ->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        return json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $UnknownDeposits,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function getDates(Request $request)
    {
        $dates = UnknownDeposit::select(DB::raw('distinct uploaded_at as value, uploaded_at as text'))->orderBy('uploaded_at', 'desc')->get();
        return $dates;
        // $created_at = [];
        // foreach ($dates as $date) {
        //     $created_at[] = $date->created_at;
        // }
        // return json_encode([
        //     'data' => $created_at,
        // ], JSON_UNESCAPED_UNICODE);
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
        $now = Carbon::now()->toDateTimeString();
        // UnknownDeposit::where('uploaded_at', $today)->delete();
        // (new UnknownDepositsImport)->import($request->file('file')->path(), null, \Maatwebsite\Excel\Excel::XLSX);
        _Excel::import(new UnknownDepositsImport($now), $request->file('file'));
        $UnknownDeposit = UnknownDeposit::with(['ClientDepositIdentificationCode.Client.ClientDepositProof'])
            ->has('ClientDepositIdentificationCode')->where('uploaded_at', $now)->first();
        if (!is_object($UnknownDeposit)) {
            $UnknownDeposit = UnknownDeposit::with(['ClientBankCard.Client'])
                ->has('ClientBankCard')->where('uploaded_at', $now)->first();
            if (is_object($UnknownDeposit)) {
                $Client = $UnknownDeposit->ClientBankCard->Client;
                $IDCard = $Client->ClientCNIDCard;
                if ("{$IDCard->surname} {$IDCard->given_name}" == $UnknownDeposit->account_name) {
                    $UnknownDeposit->status = 'bank_account_matched';
                    $UnknownDeposit->save();
                    $ClientDepositProof = $Client->ClientDepositProof;
                    $ClientDepositProof->deposit_amount = $UnknownDeposit->amount_in;
                    $ClientDepositProof->save();
                } else {
                    $IDCard = $Client->ClientHKIDCard;
                    if ($IDCard->name_en == $UnknownDeposit->account_name) {
                        $UnknownDeposit->status = 'bank_account_matched';
                        $UnknownDeposit->save();
                        $ClientDepositProof = $Client->ClientDepositProof;
                        $ClientDepositProof->deposit_amount = $UnknownDeposit->amount_in;
                        $ClientDepositProof->save();
                    } else {
                        $IDCard = $Client->ClientOtherIDCard;
                        if ($IDCard->name_en == $UnknownDeposit->account_name) {
                            $UnknownDeposit->status = 'bank_account_matched';
                            $UnknownDeposit->save();
                            $ClientDepositProof = $Client->ClientDepositProof;
                            $ClientDepositProof->deposit_amount = $UnknownDeposit->amount_in;
                            $ClientDepositProof->save();
                        } else {
                            $UnknownDeposit = UnknownDeposit::with(['ClientAyersAccount.Client.ClientDepositProof'])
                                ->has('ClientAyersAccount')->where('uploaded_at', $now)->first();
                            if (is_object($UnknownDeposit)) {
                                $UnknownDeposit->status = 'ayers_account_matched';
                                $UnknownDeposit->save();
                                $ClientDepositProof = $UnknownDeposit->ClientAyersAccount->Client->ClientDepositProof;
                                $ClientDepositProof->deposit_amount = $UnknownDeposit->amount_in;
                                $ClientDepositProof->save();
                            }
                        }
                    }
                }
            }
        } else {
            $UnknownDeposit->status = 'code_matched';
            $UnknownDeposit->save();
            $ClientDepositProof = $UnknownDeposit->ClientDepositIdentificationCode->Client->ClientDepositProof;
            $ClientDepositProof->deposit_amount = $UnknownDeposit->amount_in;
            $ClientDepositProof->save();
        }
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
        //
    }

    public function downloadUnknownDeposits(Request $request)
    {
        return $this->exportUnknownDeposits($request->input('uploaded_at'));
    }
}
