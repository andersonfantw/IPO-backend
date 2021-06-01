<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountReportSendingSummaryController extends HomeController
{
    protected $name = 'AccountReportSendingSummary';

    public function show(Request $request)
    {
        return view('AccountReport', $this->setViewParameters($request));
    }
}
