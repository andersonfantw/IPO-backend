<?php
return [
    'rule' => [
        'id'=>'integer|min:0|max:2147483647',
        'account_no'=>'required|string|regex:/^[0-9]*$/|min:7|max:8',
        'ipo_activity_period_id'=>'integer|min:0|max:2147483647',
        'start_date'=>'required|date|date_format:Y-m-d',
        'end_date'=>'required|date|date_format:Y-m-d',
        'report_make_date'=>'required|date|date_format:Y-m-d',
        'report' => '',
    ],
    'backend' => [
        'deposit' => [
        ],
    ],
    'frontend' => [
        'deposit' => [
        ],
    ]
];
