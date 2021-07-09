<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountOverviewNotification;

class AccountOverviewNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function batchStore(array $client_acc_id_list, string $issued_by, Carbon $issued_time, string $title, string $content)
    {
        if(!$client_acc_id_list) return false;

        AccountOverviewNotification::insert(
            array_map(function($client_acc_id){
                return [
                    'client_acc_id' => $client_acc_id,
                    'issued_by' => $issued_by,
                    'issued_time' => $issued_time,
                    'status' => 'unread',
                    'title' => $title,
                    'content' => $content,
                ];
            },$client_acc_id_list)
        );
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
