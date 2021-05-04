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
});

Route::prefix('UnauditedList2')->group(function () {
    Route::any('/all_data', 'UnauditedList2Controller@getData');
});

Route::prefix('RejectedList1')->group(function () {
    Route::any('/all_data', 'RejectedList1Controller@getData');
});

Route::prefix('ReauditList1')->group(function () {
    Route::any('/all_data', 'ReauditList1Controller@getData');
});

Route::prefix('DeliverableList2')->group(function () {
    Route::any('/all_data', 'DeliverableList2Controller@getData');
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
});

Route::prefix('OpenAccountEmail')->group(function () {
    Route::any('/send', 'EmailController@sendOpenAccountEmail');
});

Route::prefix('ClientFundInRequests')->group(function () {
    Route::any('/all_data', 'ClientFundInRequestsController@getData');
});

Route::prefix('ClientHKFundOutRequests')->group(function () {
    Route::any('/all_data', 'ClientHKFundOutRequestsController@getData');
});
