<?php return [
    '權限管理' => [
        'PermissionController',
    ],
    'PermissionController' => '權限管理',
    '查看開戶進度' => [
        'ClientProgressController',
    ],
    'ClientProgressController' => '查看開戶進度',
    '一審資料未審核清單' => [
        'UnauditedList1Controller',
        'AuditClientController',
        'ViewClientController',
    ],
    'UnauditedList1Controller' => '一審資料未審核清單',
    '一審資料再審核清單' => [
        'ReauditList1Controller',
        'AuditClientController',
        'ViewClientController',
    ],
    '資料駁回清單' => [
        'RejectedList1Controller',
        'ViewClientController',
    ],
    '二審資料未審核清單' => [
        'UnauditedList2Controller',
        'AuditClientController',
        'ViewClientController',
    ],
    '二審資料可投遞清單' => [
        'DeliverableList2Controller',
    ],
    '開戶信發送清單' => [
        'SendingEmailListController',
    ],
    '年度通知書發送清單' => [
        'AccountReportSendingSummaryController',
    ],
    '通知發出記錄' => [
        'NotificationGroupController',
        'NotificationRecordController',
    ],
    '添加銀行卡申請' => [
        'ClientBankCardsController',
    ],
    '添加信用卡申請' => [
        'ClientCreditCardsController',
    ],
    '存款申請' => [
        'ClientFundInRequestsController',
    ],
    '香港出款申請' => [
        'ClientHKFundOutRequestsController',
    ],
    '海外出款申請' => [
        'ClientOverseasFundOutRequestsController',
    ],
    '內部轉帳申請' => [
        'ClientFundInternalTransferRequestsController',
    ],
    '銀盛信用卡出款申請' => [
        'ClientCreditCardFundOutRequestsController',
    ],
    '住址證明修改申請' => [
        'ClientAddressProofUpdatesController',
    ],
];
