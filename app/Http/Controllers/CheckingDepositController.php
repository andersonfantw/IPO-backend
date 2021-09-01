<?php

namespace App\Http\Controllers;

use App\Imports\UnknownDepositsImport;
use App\UnknownDeposit;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;

class CheckingDepositController extends Controller
{
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
            ['key' => 'value_date', 'sortable' => true],
            ['key' => 'type', 'sortable' => true],
            ['key' => 'identification_code', 'sortable' => true],
            ['key' => 'amount_in', 'sortable' => true],
            ['key' => 'balance', 'sortable' => true],
            ['key' => 'account_no', 'sortable' => true],
            ['key' => 'account_name', 'sortable' => true],
        ];
        $this->filter_type = [
            'transaction_date' => 'betweenDate',
            'value_date' => 'betweenDate',
            'type' => 'equals',
            'identification_code' => 'startsWith',
            'amount_in' => 'equals',
            'balance' => 'equals',
            'account_no' => 'startsWith',
            'account_name' => 'betweenDate',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $UnknownDeposits = UnknownDeposit::where('created_at', 'like', "$today%")->paginate($request->input('perPage'), ['*'], 'page', $request->input('pageNumber'));
        return json_encode([
            'fields' => $this->fields,
            'filter_type' => $this->filter_type,
            'data' => $UnknownDeposits,
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
        $today = Carbon::today()->toDateString();
        UnknownDeposit::where('created_at', 'like', "$today%")->delete();
        // (new UnknownDepositsImport)->import($request->file('file')->path(), null, \Maatwebsite\Excel\Excel::XLSX);
        Excel::import(new UnknownDepositsImport, $request->file('file')->path());
        // return $request;
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
}
