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

Route::get('/', 'Controller@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'ResetPreviewingBy'])->group(function () {
    Route::get('/ClientProgress', 'ClientProgressController@index')->name('ClientProgress');

    Route::get('/UnauditedList1', 'UnauditedList1Controller@index')->name('UnauditedList1');

    Route::get('/UnauditedList2', 'UnauditedList2Controller@index')->name('UnauditedList2');

    Route::get('/RejectedList1', 'RejectedList1Controller@index')->name('RejectedList1');

    Route::get('/ReauditList1', 'ReauditList1Controller@index')->name('ReauditList1');

    Route::any('/AuditClient', 'AuditClientController@index')->name('AuditClient')->middleware([
        'PreviewClient',
    ]);

    Route::any('/AuditClientFundInRequest', 'AuditClientFundInRequestController@index')->name('AuditClientFundInRequest')->middleware([
        'PreviewClientFundInRequest',
    ]);

    Route::any('/DoAuditClientFundInRequest', 'AuditClientFundInRequestController@audit')->name('DoAuditClientFundInRequest');

    Route::any('/AuditClientFundInternalTransferRequest', 'AuditClientFundInternalTransferRequestController@index')->name('AuditClientFundInternalTransferRequest')->middleware([
        'PreviewClientFundInternalTransferRequest',
    ]);

    Route::any('/DoAuditClientFundInternalTransferRequest', 'AuditClientFundInternalTransferRequestController@audit')->name('DoAuditClientFundInternalTransferRequest');

    Route::any('/AuditClientHKFundOutRequest', 'AuditClientHKFundOutRequestController@index')->name('AuditClientHKFundOutRequest')->middleware([
        'PreviewClientHKFundOutRequest',
    ]);

    Route::any('/DoAuditClientHKFundOutRequest', 'AuditClientHKFundOutRequestController@audit')->name('DoAuditClientHKFundOutRequest');

    Route::any('/AuditClientCreditCardFundOutRequest', 'AuditClientCreditCardFundOutRequestController@index')->name('AuditClientCreditCardFundOutRequest')->middleware([
        'PreviewClientCreditCardFundOutRequest',
    ]);

    Route::any('/DoAuditClientCreditCardFundOutRequest', 'AuditClientCreditCardFundOutRequestController@audit')->name('DoAuditClientCreditCardFundOutRequest');

    Route::any('/AuditClientOverseasFundOutRequest', 'AuditClientOverseasFundOutRequestController@index')->name('AuditClientOverseasFundOutRequest')->middleware([
        'PreviewClientOverseasFundOutRequest',
    ]);

    Route::any('/DoAuditClientOverseasFundOutRequest', 'AuditClientOverseasFundOutRequestController@audit')->name('DoAuditClientOverseasFundOutRequest');

    Route::any('/AuditClientBankCard', 'AuditClientBankCardController@index')->name('AuditClientBankCard')->middleware([
        'PreviewClientBankCard',
    ]);

    Route::any('/DoAuditClientBankCard', 'AuditClientBankCardController@audit')->name('DoAuditClientBankCard');

    Route::any('/AuditClientCreditCard', 'AuditClientCreditCardController@index')->name('AuditClientCreditCard');

    Route::any('/DoAuditClientCreditCard', 'AuditClientCreditCardController@audit')->name('DoAuditClientCreditCard');

    Route::any('/ViewClient', 'ViewClientController@index')->name('ViewClient');

    Route::any('/ViewClientFundInRequest', 'ViewClientFundInRequestController@index')->name('ViewClientFundInRequest');

    Route::any('/ViewClientFundInternalTransferRequest', 'ViewClientFundInternalTransferRequestController@index')->name('ViewClientFundInternalTransferRequest');

    Route::any('/ViewClientHKFundOutRequest', 'ViewClientHKFundOutRequestController@index')->name('ViewClientHKFundOutRequest');

    Route::any('/ViewClientCreditCardFundOutRequest', 'ViewClientCreditCardFundOutRequestController@index')->name('ViewClientCreditCardFundOutRequest');

    Route::any('/ViewClientOverseasFundOutRequest', 'ViewClientOverseasFundOutRequestController@index')->name('ViewClientOverseasFundOutRequest');

    Route::any('/ViewClientBankCard', 'ViewClientBankCardController@index')->name('ViewClientBankCard');

    Route::any('/ViewClientAddressProofUpdate', 'ViewClientBankCardController@index')->name('ViewClientAddressProofUpdate');

    Route::any('/ViewClientCreditCard', 'ViewClientCreditCardController@index')->name('ViewClientCreditCard');

    Route::any('/audit1', 'AuditClientController@audit1')->name('audit1');

    Route::any('/DeliverableList2', 'DeliverableList2Controller@index')->name('DeliverableList2');

    Route::any('/SendingEmailList', 'SendingEmailListController@index')->name('SendingEmailList');

    Route::any('/GenerateAyersAccount', 'AyersAccountController@generate')->name('GenerateAyersAccount');

    Route::any('/ClientFundInRequests', 'ClientFundInRequestsController@index')->name('ClientFundInRequests');

    Route::any('/ClientHKFundOutRequests', 'ClientHKFundOutRequestsController@index')->name('ClientHKFundOutRequests');

    Route::any('/ClientOverseasFundOutRequests', 'ClientOverseasFundOutRequestsController@index')->name('ClientOverseasFundOutRequests');

    Route::any('/ClientFundInternalTransferRequests', 'ClientFundInternalTransferRequestsController@index')->name('ClientFundInternalTransferRequests');

    Route::any('/ClientCreditCardFundOutRequests', 'ClientCreditCardFundOutRequestsController@index')->name('ClientCreditCardFundOutRequests');

    Route::any('/ClientAddressProofUpdates', 'ClientAddressProofUpdatesController@index')->name('ClientAddressProofUpdates');

    Route::any('/AuditClientAddressProofUpdate', 'AuditClientAddressProofUpdateController@audit')->name('AuditClientAddressProofUpdate');

    Route::any('/ClientBankCards', 'ClientBankCardsController@index')->name('ClientBankCards');

    Route::any('/ClientCreditCards', 'ClientCreditCardsController@index')->name('ClientCreditCards');

    // Route::middleware(['cors'])->group(function () {
    Route::any('/LoadIDCardFace', 'AuditClientController@loadIDCardFace')->name('LoadIDCardFace');
    Route::any('/LoadIDCardBack', 'AuditClientController@loadIDCardBack')->name('LoadIDCardBack');
    Route::any('/LoadHKBankCard', 'AuditClientController@loadHKBankCard')->name('LoadHKBankCard');
    Route::any('/LoadCNBankCard', 'AuditClientController@loadCNBankCard')->name('LoadCNBankCard');
    Route::any('/LoadOtherBankCard', 'AuditClientController@loadOtherBankCard')->name('LoadOtherBankCard');
    Route::any('/LoadNameCard', 'AuditClientController@loadNameCard')->name('LoadNameCard');
    Route::any('/LoadSignature', 'AuditClientController@loadSignature')->name('LoadSignature');
    Route::any('/LoadDepositProof', 'AuditClientController@loadDepositProof')->name('LoadDepositProof');
    Route::any('/LoadAddressProof', 'AuditClientController@loadAddressProof')->name('LoadAddressProof');
    Route::any('/LoadAddressProofUpdate', 'ViewClientAddressProofUpdateController@loadAddressProofUpdate')->name('LoadAddressProofUpdate');
    Route::any('/LoadFundInReceipt', 'ViewClientFundInRequestController@loadReceipt')->name('LoadFundInReceipt');
    Route::any('/LoadFundInBankCard', 'ViewClientFundInRequestController@loadBankcard')->name('LoadFundInBankCard');
    Route::any('/LoadBankCard', 'ViewClientBankCardController@loadBankCard')->name('LoadBankCard');
    Route::any('/LoadCreditCard', 'ViewClientCreditCardController@loadCreditCard')->name('LoadCreditCard');
    // });

    Route::resource('Permission', 'UserRoleController');

});

Route::any('/Chinayss', 'UnauditedList1Controller@Chinayss')->name('Chinayss');
Route::any('/TestReport', 'UnauditedList1Controller@test')->name('TestReport');
Route::any('/QRCode', 'AEController@QRCode')->name('QRCode');
Route::any('/generateQRCode', 'AEController@generateQRCode')->name('generateQRCode');

// Anderson 2021-05-31 start
Route::middleware(['auth'])->group(function () {
    Route::get('/AccountReportSendingSummary', 'AccountReportSendingSummaryController@indexView')->name('AccountReportSendingSummary');
    Route::get('/AccountReportSendingSummary/{AccountReportSendingSummary}', 'AccountReportSendingSummaryController@show')->where(['AccountReportSendingSummary' => '[0-9]+']);
    Route::get('/AccountReportSendingSummary/{AccountReportSendingSummary}/ShowHtml/{account_no}', 'AccountReportController@showHtml')->where(['AccountReportSendingSummary' => '[0-9]+', 'account_no' => '[0-9]{7,8}']);
    Route::get('/AccountReportSendingSummary/{AccountReportSendingSummary}/ShowPdf/{account_no}', 'AccountReportController@showPdf')->where(['AccountReportSendingSummary' => '[0-9]+', 'account_no' => '[0-9]{7,8}']);
    Route::get('/AccountReportSendingSummary/{AccountReportSendingSummary}/DownloadPdf/{account_no}', 'AccountReportController@downloadPdf')->where(['AccountReportSendingSummary' => '[0-9]+', 'account_no' => '[0-9]{7,8}']);

    Route::get('/max/deposit', 'SimpleListController@deposit');
    Route::get('/max/MailList', 'SimpleListController@MailList');
    Route::get('/max/OpenStatus', 'SimpleListController@OpenStatus');
    Route::get('/max/BankcardRejected', 'SimpleListController@BankcardRejected');

    Route::get('/sendsms', 'SimpleListController@sms');
    Route::post('/sendsms', 'SimpleListController@sendsms');

    Route::get('/NotificationSummary', 'NotificationGroupController@indexView')->name('NotificationSummary');
    Route::get('/preview_email/{template_id}', 'NotificationRecordController@preview')->where(['template_id' => '[0-9]+']);
    //Route::get('/NotificationRecords', 'NotificationRecordController@indexView');
    //Route::get('/test_db_notification','NotificationRecordController@notifyDb');
    //Route::get('/list_db_notification','NotificationRecordController@unread');
});
// Anderson 2021-05-31 end
