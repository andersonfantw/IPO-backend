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

Route::get('/phpinfo', 'Controller@phpinfo');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Route::get('/ClientProgress', 'ClientProgressController@index')->name('ClientProgress');

    // Route::get('/UnauditedList1', 'UnauditedList1Controller@index')->name('UnauditedList1');

    // Route::get('/UnauditedList2', 'UnauditedList2Controller@index')->name('UnauditedList2');

    Route::get('/RejectedList1', 'RejectedList1Controller@index')->name('RejectedList1');

    // Route::get('/ReauditList1', 'ReauditList1Controller@index')->name('ReauditList1');

    // Route::post('AuditClient', 'AuditClientController@audit')->name('AuditClient');

    // Route::any('/AuditClientFundInRequest', 'AuditClientFundInRequestController@index')->name('AuditClientFundInRequest')->middleware([
    //     'PreviewClientFundInRequest',
    // ]);

    Route::any('/DoAuditClientFundInRequest', 'AuditClientFundInRequestController@audit')->name('DoAuditClientFundInRequest');

    Route::any('/AuditClientFundInternalTransferRequest', 'AuditClientFundInternalTransferRequestController@index')->name('AuditClientFundInternalTransferRequest')->middleware([
        'PreviewClientFundInternalTransferRequest',
    ]);

    Route::any('/DoAuditClientFundInternalTransferRequest', 'AuditClientFundInternalTransferRequestController@audit')->name('DoAuditClientFundInternalTransferRequest');

    // Route::any('/AuditClientHKFundOutRequest', 'AuditClientHKFundOutRequestController@index')->name('AuditClientHKFundOutRequest')->middleware([
    //     'PreviewClientHKFundOutRequest',
    // ]);

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

    // Route::any('/DeliverableList2', 'DeliverableList2Controller@index')->name('DeliverableList2');

    // Route::any('/SendingEmailList', 'SendingEmailListController@index')->name('SendingEmailList');

    Route::any('/GenerateAyersAccount', 'AyersAccountController@generate')->name('GenerateAyersAccount');

    // Route::any('/ClientFundInRequests', 'ClientFundInRequestsController@index')->name('ClientFundInRequests');

    // Route::any('/ClientHKFundOutRequests', 'ClientHKFundOutRequestsController@index')->name('ClientHKFundOutRequests');

    // Route::any('/ClientOverseasFundOutRequests', 'ClientOverseasFundOutRequestsController@index')->name('ClientOverseasFundOutRequests');

    // Route::any('/ClientFundInternalTransferRequests', 'ClientFundInternalTransferRequestsController@index')->name('ClientFundInternalTransferRequests');

    // Route::any('/ClientCreditCardFundOutRequests', 'ClientCreditCardFundOutRequestsController@index')->name('ClientCreditCardFundOutRequests');

    // Route::any('/ClientAddressProofUpdates', 'ClientAddressProofUpdatesController@index')->name('ClientAddressProofUpdates');

    Route::any('/AuditClientAddressProofUpdate', 'AuditClientAddressProofUpdateController@audit')->name('AuditClientAddressProofUpdate');

    // Route::any('/ClientBankCards', 'ClientBankCardsController@index')->name('ClientBankCards');

    // Route::any('/ClientCreditCards', 'ClientCreditCardsController@index')->name('ClientCreditCards');

    // Route::middleware(['cors'])->group(function () {
    Route::any('/LoadIDCardFace', 'ClientController@loadIDCardFace')->name('LoadIDCardFace');
    Route::any('/LoadIDCardBack', 'ClientController@loadIDCardBack')->name('LoadIDCardBack');
    Route::any('/LoadHKBankCard', 'ClientController@loadHKBankCard')->name('LoadHKBankCard');
    Route::any('/LoadCNBankCard', 'ClientController@loadCNBankCard')->name('LoadCNBankCard');
    Route::any('/LoadOtherBankCard', 'ClientController@loadOtherBankCard')->name('LoadOtherBankCard');
    Route::any('/LoadNameCard', 'ClientController@loadNameCard')->name('LoadNameCard');
    Route::any('/LoadSignature', 'ClientController@loadSignature')->name('LoadSignature');
    Route::any('/LoadDepositProof', 'ClientController@loadDepositProof')->name('LoadDepositProof');
    Route::any('/LoadAddressProof', 'ClientController@loadAddressProof')->name('LoadAddressProof');
    Route::any('/LoadAddressProofUpdate', 'ViewClientAddressProofUpdateController@loadAddressProofUpdate')->name('LoadAddressProofUpdate');
    Route::any('/LoadFundInReceipt', 'ViewClientFundInRequestController@loadReceipt')->name('LoadFundInReceipt');
    Route::any('/LoadFundInBankCard', 'ViewClientFundInRequestController@loadBankcard')->name('LoadFundInBankCard');
    Route::any('/LoadBankCard', 'ClientBankCardsController@loadBankCard')->name('LoadBankCard');
    Route::any('/LoadCreditCard', 'ViewClientCreditCardController@loadCreditCard')->name('LoadCreditCard');
    // });

    Route::resource('Permission', 'PermissionController');
    Route::resource('Client', 'ClientController');
    Route::resource('MenuItem', 'MenuItemController');
    Route::resource('ClientProgress', 'ClientProgressController');
    Route::resource('UnauditedList1', 'UnauditedList1Controller');
    Route::resource('ReauditList1', 'ReauditList1Controller');
    Route::resource('UnauditedList2', 'UnauditedList2Controller');
    Route::resource('DeliverableList2', 'DeliverableList2Controller');

    Route::prefix('DeliverableList2')->group(function () {
        Route::any('/list', 'DeliverableList2Controller@list');
        Route::any('/DownloadAyersImportData', 'DeliverableList2Controller@downloadAyersImportData');
        Route::any('/DownloadFilesForOpeningAccount', 'DeliverableList2Controller@downloadFilesForOpeningAccount');
    });

    Route::resource('SendingEmailList', 'SendingEmailListController');
    Route::resource('ClientBankCards', 'ClientBankCardsController');
    Route::resource('ClientCreditCards', 'ClientCreditCardsController');
    Route::resource('ClientFundInRequests', 'ClientFundInRequestsController');
    Route::resource('ClientHKFundOutRequests', 'ClientHKFundOutRequestsController');
    Route::prefix('ClientHKFundOutRequests')->group(function () {
        Route::post('search', 'ClientHKFundOutRequestsController@search');
    });
    Route::resource('ClientInternalTransferRequests', 'ClientFundInternalTransferRequestsController');
    Route::resource('ClientOverseasFundOutRequests', 'ClientOverseasFundOutRequestsController');
    Route::resource('ClientCreditCardFundOutRequests', 'ClientCreditCardFundOutRequestsController');
    Route::resource('UserRole', 'UserRoleController');
    Route::resource('RoleMenuItem', 'RoleMenuItemController');
    Route::resource('RoleControllerPermission', 'RoleControllerPermissionController');
    Route::resource('Role', 'RoleController');
    Route::resource('Controller', 'ControllerController');
    Route::resource('AuditClient', 'AuditClientController');
    Route::resource('AuditClientHKFundOutRequest', 'AuditClientHKFundOutRequestController');
    Route::resource('AuditClientFundInRequest', 'AuditClientFundInRequestController');
    Route::prefix('AyersAccount')->group(function () {
        Route::post('SetCanClose', 'AyersAccountController@setCanClose');
        Route::post('CancelCanClose', 'AyersAccountController@cancelCanClose');
    });
    Route::resource('CheckingDeposit', 'CheckingDepositController');
    Route::any('CheckingDepositDates', 'CheckingDepositController@getDates');
    Route::post('DownloadUnknownDepositsExcel', 'CheckingDepositController@downloadUnknownDeposits');
    Route::post('SendOpenAccountEmail', 'EmailController@sendOpenAccountEmail');
    Route::get('Counts', 'MenuItemController@getCounts');
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
    Route::get('/max/StatusMismatch', 'SimpleListController@StatusMismatch');

    Route::get('/sendsms', 'SimpleListController@sms');
    Route::post('/sendsms', 'SimpleListController@sendsms');

    Route::get('/NotificationSummary', 'NotificationGroupController@indexView')->name('NotificationSummary');
    Route::get('/preview_email/{template_id}', 'NotificationRecordController@preview')->where(['template_id' => '[0-9]+']);
    //Route::get('/NotificationRecords', 'NotificationRecordController@indexView');
    //Route::get('/test_db_notification','NotificationRecordController@notifyDb');
    //Route::get('/list_db_notification','NotificationRecordController@unread');
    // Route::get('test',function(){
    //    (new App\Services\NotifyService)->notify(
    //        (new App\Services\NotifyMessage)->route('email')->templateId(7)->clientId('200001')->title('測試發送訊息')
    //    );
    //});

    Route::get('/AeCommissionSummary/DownloadDetailCsv', 'AeCommissionSummaryController@detailCsv');
    Route::get('/AeCommissionSummary/DownloadDetailPdf', 'AeCommissionSummaryController@detailPdf');
    Route::get('/AeCommissionSummary/ShowSummaryPdf/{ae_commission_summary:buss_date}', 'AeCommissionSummaryController@aeCommissionSummaryReport')->name('AeCommissionSummaryReport');
    Route::get('/AeCommissionSummary/ShowSummary/{ae_commission_summary:buss_date}', 'AeCommissionSummaryController@aeCommissionSummary')->name('aeCommissionSummary');
    Route::get('/AeCommissionSummary/ShowPdf/{ae:uuid}', 'AeCommissionSummaryController@aeConfirmReport')->name('AeCommissionConfirmReportPdf');
    Route::get('/AeCommissionSummary/Show/{ae:uuid}', 'AeCommissionSummaryController@aeConfirm')->name('AeCommissionConfirmReport');
    Route::get('/AeCommissionSummary/PaymentRequestForm/{ae:uuid}', 'AeCommissionSummaryController@PaymentRequestForm');
    Route::get('/AeCommissionSummary', 'AeCommissionSummaryController@indexView')->name('AeCommissionSummary');
    Route::get('/AeCommission', 'AeCommissionSummaryController@indexView')->name('AeCommission');
    Route::get('/AeCommissionDetail', 'AeCommissionDetailController@indexView')->name('AeCommissionDetail');

    Route::prefix('api')->group(function () {
        // Anderson 2021-05-31 start
        Route::resource('AccountReportSendingSummary', 'AccountReportSendingSummaryController');
        Route::resource('AccountReportSendingSummary.AccountReport', 'AccountReportController');

        Route::get('/AccountReport/program', 'AccountReportSendingSummaryController@getProgram');
        Route::post('/find/client', 'VueController@findClient');

        Route::post('/AccountReport/MakePdf/{id}/', 'AccountReportController@makePdf')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/SendTestMail/{id}/', 'AccountReportController@sendTestMail')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/SendMail/{id}/', 'AccountReportController@sendMail')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/RemoveClient/{id}/', 'AccountReportController@removeClient')->where(['id' => '[0-9]+']);

        // MakeAll 對應功能
        Route::post('/AccountReport/MakeAll/{id}/', 'AccountReportController@makeAll')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/StopMake/{id}/', 'AccountReportController@stopMake')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/ClearMake/{id}/', 'AccountReportController@clearMake')->where(['id' => '[0-9]+']);
        // SendAll 對應功能
        Route::post('/AccountReport/SendAll/{id}/', 'AccountReportController@sendAll')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/StopSend/{id}/', 'AccountReportController@stopSend')->where(['id' => '[0-9]+']);
        Route::post('/AccountReport/ClearSend/{id}/', 'AccountReportController@clearSend')->where(['id' => '[0-9]+']);

        // 通知任務中心
        Route::resource('notify_client', 'NotificationRecordController');
        Route::resource('notify_group', 'NotificationGroupController');
        Route::resource('system_notification_list', 'NotificationRecordController');

        Route::get('/notify_group/{id}/list/', 'NotificationGroupController@list')->where(['id' => '[0-9]+']);
        // Route::post('/notify_client/{id}/send/', 'NotificationRecordController@send')->where(['id' => '[0-9]+']);
        Route::post('/notify_group/{id}/SendAll/', 'NotificationGroupController@sendAll')->where(['id' => '[0-9]+']);
        Route::post('/notify_group/{id}/store/{client_id}/', 'NotificationGroupController@addClient')->where(['id' => '[0-9]+', 'client_id' => '[0-9]+']);
        Route::post('/notify_group/uploadCustomizeNoticeList', 'NotificationGroupController@customizeNotice');

        Route::get('forbidden_words', 'VueController@ForbiddenWords');
        Route::get('template_list', 'VueController@NotificationTemplateList');
        Route::get('client_info', 'VueController@ClientInfo');
        Route::post('/list/clients', 'VueController@ListClients');

        // Route::resource('NotificationSummary', 'NotificationGroupController');
        // Route::resource('NotificationSummary.NotificationRecords', 'NotificationRecordController');

        //ae獎金計算
        Route::get('ae_commission_summary/detail', 'AeCommissionSummaryController@detail');
        Route::post('ae_commission_summary/recalculate', 'AeCommissionSummaryController@recalculate');
        Route::post('ae_commission_summary/pay', 'AeCommissionSummaryController@pay');
        Route::resource('ae_commission_summary', 'AeCommissionSummaryController');
        Route::get('/list/ae', 'VueController@getAe');
        Route::get('/list/staff', 'VueController@getStaff');
        Route::resource('ipo_interest_list', 'IpoInterestListController');
        Route::resource('ipo_interest_import', 'IpoInterestImportController');

        // 顧客資料修改
        Route::get('/ClientDataUpdate/model_cname', 'ClientDataUpdateController@modelCname');
        Route::get('/ClientDataUpdate/{model}/{client_ayers_account:uuid}/{image}', 'ClientDataUpdateController@image')->where(['model' => '[a-zA-Z]+', 'image' => '[a-z_]+']);
        Route::get('/ClientDataUpdate/{model}/{client_ayers_account:uuid}', 'ClientDataUpdateController@show')->where(['model' => '[a-zA-Z]+']);
        Route::put('/ClientDataUpdate/{model}/{client_ayers_account:uuid}', 'ClientDataUpdateController@update')->where(['model' => '[a-zA-Z]+']);
        Route::resource('ClientDataUpdate', 'ClientDataUpdateController');
        // Anderson 2021-05-31 end
    });
});
// Anderson 2021-05-31 end
