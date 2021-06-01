<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('AE')->group(function () {
    Route::any('/create', 'AEController@create');
    Route::any('/createStaff', 'AEController@createStaff');
    Route::any('/createSalesman', 'AEController@createSalesman');
    Route::any('/QRCode', 'AEController@QRCode');
});

Route::prefix('Email')->group(function () {
    Route::any('/send', 'EmailController@send');
});

Route::prefix('UnauditedList1')->group(function () {
    Route::any('/all_data', 'UnauditedList1Controller@getData');
    Route::any('/NoOfNews', 'UnauditedList1Controller@getNoOfNews');
});

Route::prefix('UnauditedList2')->group(function () {
    Route::any('/all_data', 'UnauditedList2Controller@getData');
    Route::any('/NoOfNews', 'UnauditedList2Controller@getNoOfNews');
});

Route::prefix('RejectedList1')->group(function () {
    Route::any('/all_data', 'RejectedList1Controller@getData');
    Route::any('/NoOfNews', 'RejectedList1Controller@getNoOfNews');
});

Route::prefix('ReauditList1')->group(function () {
    Route::any('/all_data', 'ReauditList1Controller@getData');
    Route::any('/NoOfNews', 'ReauditList1Controller@getNoOfNews');
});

Route::prefix('DeliverableList2')->group(function () {
    Route::any('/all_data', 'DeliverableList2Controller@getData');
    Route::any('/NoOfNews', 'DeliverableList2Controller@getNoOfNews');
    Route::any('/DownloadAyersImportData', 'DeliverableList2Controller@downloadAyersImportData');
});

Route::prefix('Ayers')->group(function () {
    Route::any('/testCSVImport', 'HomeController@testCSVImport');
});

Route::prefix('AyersAccount')->group(function () {
    Route::any('/generate', 'AyersAccountController@generate');
});

Route::prefix('SendingEmailList')->group(function () {
    Route::any('/all_data', 'SendingEmailListController@getData');
    Route::any('/NoOfNews', 'SendingEmailListController@getNoOfNews');
});

Route::prefix('OpenAccountEmail')->group(function () {
    Route::any('/send', 'EmailController@sendOpenAccountEmail');
});

Route::prefix('ClientFundInRequests')->group(function () {
    Route::any('/all_data', 'ClientFundInRequestsController@getData');
    Route::any('/DownloadAyersImportData', 'ClientFundInRequestsController@downloadAyersImportData');
});

Route::prefix('ClientHKFundOutRequests')->group(function () {
    Route::any('/all_data', 'ClientHKFundOutRequestsController@getData');
    Route::any('/DownloadAyersImportData', 'ClientHKFundOutRequestsController@downloadAyersImportData');
});

Route::prefix('ClientFundInternalTransferRequests')->group(function () {
    Route::any('/all_data', 'ClientFundInternalTransferRequestsController@getData');
    Route::any('/DownloadClientFundInternalTransferFundInRequests', 'ClientFundInternalTransferRequestsController@downloadClientFundInternalTransferFundInRequests');
    Route::any('/DownloadClientFundInternalTransferFundOutRequests', 'ClientFundInternalTransferRequestsController@downloadClientFundInternalTransferFundOutRequests');
});

Route::prefix('ClientOverseasFundOutRequests')->group(function () {
    Route::any('/all_data', 'ClientOverseasFundOutRequestsController@getData');
    Route::any('/DownloadAyersImportData', 'ClientOverseasFundOutRequestsController@downloadAyersImportData');
});

Route::prefix('ClientCreditCardFundOutRequests')->group(function () {
    Route::any('/all_data', 'ClientCreditCardFundOutRequestsController@getData');
});

Route::prefix('ClientBankCards')->group(function () {
    Route::any('/all_data', 'ClientBankCardsController@getData');
});

// Anderson 2021-05-31 start
Route::resources('/AccountReport', 'AccountReportController');
Route::post('/AccountReport/SendAll', 'AccountReportController@sendAll');
Route::post('/AccountReport/StopSending', 'AccountReportController@stopSending');
Route::post('/AccountReport/ShowPdf', 'AccountReportController@showPdf');
Route::post('/AccountReport/SendTestMail', 'AccountReportController@sendTestMail');
// Anderson 2021-05-31 end
