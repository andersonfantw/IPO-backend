<?php return [
    '查看開戶進度' => [
        'ClientProgressController',
    ],
    '一審資料未審核清單' => [
        'UnauditedList1Controller',
        'AuditClientController',
        'ViewClientController',
    ],
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
];
