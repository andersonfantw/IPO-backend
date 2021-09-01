<?php

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

// Route::any('/TestRoute', 'Controller@TestRoute');

Route::middleware('auth:api')->get('/user', 'Controller@user');

Route::prefix('ClientProgress')->group(function () {
    Route::any('/list', 'ClientProgressController@list');
    Route::any('/query', 'ClientProgressController@query');
});

Route::prefix('Client')->group(function () {
    Route::any('/details', 'ViewClientController@getClientDetails');
    Route::post('/audit', 'AuditClientController@audit1');
    Route::post('/setCanClose', 'AuditClientController@setCanClose');
    Route::post('/cancelCanCloseAC', 'AuditClientController@cancelCanCloseAC');
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
    Route::any('/list', 'UnauditedList1Controller@list');
    // Route::any('/NoOfNews', 'UnauditedList1Controller@getNoOfNews');
});

Route::prefix('UnauditedList2')->group(function () {
    Route::any('/list', 'UnauditedList2Controller@list');
    // Route::any('/NoOfNews', 'UnauditedList2Controller@getNoOfNews');
});

Route::prefix('RejectedList1')->group(function () {
    Route::any('/list', 'RejectedList1Controller@list');
    // Route::any('/NoOfNews', 'RejectedList1Controller@getNoOfNews');
    Route::any('/refund', 'RejectedList1Controller@refund');
});

Route::prefix('ReauditList1')->group(function () {
    Route::any('/list', 'ReauditList1Controller@list');
    // Route::any('/NoOfNews', 'ReauditList1Controller@getNoOfNews');
});

Route::prefix('DeliverableList2')->group(function () {
    Route::any('/list', 'DeliverableList2Controller@list');
    // Route::any('/NoOfNews', 'DeliverableList2Controller@getNoOfNews');
    Route::any('/DownloadAyersImportData', 'DeliverableList2Controller@downloadAyersImportData');
    Route::any('/DownloadFilesForOpeningAccount', 'DeliverableList2Controller@downloadFilesForOpeningAccount');
});

Route::prefix('Ayers')->group(function () {
    Route::any('/testCSVImport', 'HomeController@testCSVImport');
});

Route::prefix('AyersAccount')->group(function () {
    Route::any('/generate', 'AyersAccountController@generate');
    // Route::any('/generateAccountOpeningForm', 'AyersAccountController@generateAccountOpeningForm');
});

Route::prefix('SendingEmailList')->group(function () {
    Route::any('/list', 'SendingEmailListController@list');
    // Route::any('/NoOfNews', 'SendingEmailListController@getNoOfNews');
});

Route::prefix('OpenAccountEmail')->group(function () {
    Route::any('/send', 'EmailController@sendOpenAccountEmail');
});

Route::prefix('ClientFundInRequests')->group(function () {
    Route::any('/list', 'ClientFundInRequestsController@list');
    Route::any('/DownloadAyersImportData', 'ClientFundInRequestsController@downloadAyersImportData');
    Route::any('/DownloadAyersImportData2', 'ClientFundInRequestsController@downloadAyersImportData2');
    Route::any('/Audit', 'AuditClientFundInRequestController@fastAudit');
});

Route::prefix('ClientHKFundOutRequests')->group(function () {
    Route::any('/list', 'ClientHKFundOutRequestsController@list');
    Route::any('/DownloadAyersImportData', 'ClientHKFundOutRequestsController@downloadAyersImportData');
    Route::any('/DownloadAyersImportData2', 'ClientHKFundOutRequestsController@downloadAyersImportData2');
    Route::any('/Audit', 'AuditClientHKFundOutRequestController@fastAudit');
});

Route::prefix('ClientFundInternalTransferRequests')->group(function () {
    Route::any('/list', 'ClientFundInternalTransferRequestsController@list');
    Route::any('/DownloadClientFundInternalTransferFundInRequests', 'ClientFundInternalTransferRequestsController@downloadClientFundInternalTransferFundInRequests');
    Route::any('/DownloadClientFundInternalTransferFundOutRequests', 'ClientFundInternalTransferRequestsController@downloadClientFundInternalTransferFundOutRequests');
});

Route::prefix('ClientOverseasFundOutRequests')->group(function () {
    Route::any('/list', 'ClientOverseasFundOutRequestsController@list');
    Route::any('/DownloadAyersImportData', 'ClientOverseasFundOutRequestsController@downloadAyersImportData');
});

Route::prefix('ClientCreditCardFundOutRequests')->group(function () {
    Route::any('/list', 'ClientCreditCardFundOutRequestsController@list');
});

Route::prefix('ClientBankCards')->group(function () {
    Route::any('/list', 'ClientBankCardsController@list');
});

Route::prefix('ClientCreditCards')->group(function () {
    Route::any('/list', 'ClientCreditCardsController@list');
});

Route::prefix('ClientAddressProofUpdates')->group(function () {
    Route::any('/list', 'ClientAddressProofUpdatesController@list');
});
