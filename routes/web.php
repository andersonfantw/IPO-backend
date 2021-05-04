<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/UnauditedList1', 'UnauditedList1Controller@index')->name('UnauditedList1');

    Route::get('/UnauditedList2', 'UnauditedList2Controller@index')->name('UnauditedList2');

    Route::get('/RejectedList1', 'RejectedList1Controller@index')->name('RejectedList1');

    Route::get('/ReauditList1', 'ReauditList1Controller@index')->name('ReauditList1');

    Route::any('/AuditClient', 'AuditClientController@index')->name('AuditClient');

    Route::any('/AuditClientFundInRequest', 'AuditClientFundInRequestController@index')->name('AuditClientFundInRequest');

    Route::any('/DoAuditClientFundInRequest', 'AuditClientFundInRequestController@audit')->name('DoAuditClientFundInRequest');

    Route::any('/AuditClientFundInternalTransferRequest', 'AuditClientFundInternalTransferRequestController@index')->name('AuditClientFundInternalTransferRequest');

    Route::any('/AuditClientHKFundOutRequest', 'AuditClientHKFundOutRequestController@index')->name('AuditClientHKFundOutRequest');

    Route::any('/AuditClientOverseasFundOutRequest', 'AuditClientOverseasFundOutRequestController@index')->name('AuditClientOverseasFundOutRequest');

    Route::any('/ViewClient', 'ViewClientController@index')->name('ViewClient');

    Route::any('/ViewClientFundInRequest', 'ViewClientFundInRequestController@index')->name('ViewClientFundInRequest');

    Route::any('/ViewClientFundInternalTransferRequest', 'ViewClientFundInternalTransferRequestController@index')->name('ViewClientFundInternalTransferRequest');

    Route::any('/ViewClientHKFundOutRequest', 'ViewClientHKFundOutRequestController@index')->name('ViewClientHKFundOutRequest');

    Route::any('/ViewClientOverseasFundOutRequest', 'ViewClientOverseasFundOutRequestController@index')->name('ViewClientOverseasFundOutRequest');

    Route::any('/audit1', 'AuditClientController@audit1')->name('audit1');

    Route::any('/DeliverableList2', 'DeliverableList2Controller@index')->name('DeliverableList2');

    Route::any('/SendingEmailList', 'SendingEmailListController@index')->name('SendingEmailList');

    Route::any('/GenerateAyersAccount', 'AyersAccountController@generate')->name('GenerateAyersAccount');

    Route::any('/ClientFundInRequests', 'ClientFundInRequestsController@index')->name('ClientFundInRequests');

    Route::any('/ClientHKFundOutRequests', 'ClientHKFundOutRequestsController@index')->name('ClientHKFundOutRequests');

    Route::any('/ClientOverseasFundOutRequests', 'ClientOverseasFundOutRequestsController@index')->name('ClientOverseasFundOutRequests');

    Route::any('/ClientFundInternalTransferRequests', 'ClientFundInternalTransferRequestsController@index')->name('ClientFundInternalTransferRequests');

    Route::any('/LoadIDCardFace', 'AuditClientController@loadIDCardFace')->name('LoadIDCardFace');
    Route::any('/LoadIDCardBack', 'AuditClientController@loadIDCardBack')->name('LoadIDCardBack');
    Route::any('/LoadHKBankCard', 'AuditClientController@loadHKBankCard')->name('LoadHKBankCard');
    Route::any('/LoadCNBankCard', 'AuditClientController@loadCNBankCard')->name('LoadCNBankCard');
    Route::any('/LoadOtherBankCard', 'AuditClientController@loadOtherBankCard')->name('LoadOtherBankCard');
    Route::any('/LoadNameCard', 'AuditClientController@loadNameCard')->name('LoadNameCard');
    Route::any('/LoadSignature', 'AuditClientController@loadSignature')->name('LoadSignature');
    Route::any('/LoadDepositProof', 'AuditClientController@loadDepositProof')->name('LoadDepositProof');
    Route::any('/LoadAddressProof', 'AuditClientController@loadAddressProof')->name('LoadAddressProof');
});

Route::any('/Chinayss', 'UnauditedList1Controller@Chinayss')->name('Chinayss');
Route::any('/TestReport', 'UnauditedList1Controller@test')->name('TestReport');
Route::any('/QRCode', 'AEController@QRCode')->name('QRCode');
Route::any('/generateQRCode', 'AEController@generateQRCode')->name('generateQRCode');
