<?php return [
    'MinProgress' => [
        'zh-hk' => 1,
        'zh-cn' => [
            'WithOtherBankCard' => 2,
            'WithHKBankCard' => 2,
        ],
        'others' => 1,
    ],
    'MaxProgress' => [
        'zh-hk' => 15,
        'zh-cn' => [
            'WithOtherBankCard' => 19,
            'WithHKBankCard' => 15,
        ],
        'others' => 16,
    ],
    'Progress' => [
        'zh-hk' => [
            1 => 'zh-hk.Agreement',
            2 => 'zh-hk.ClientIDCard',
            3 => 'zh-hk.AddressProof',
            4 => 'zh-hk.ClientHKBankCard',
            5 => 'zh-hk.ClientWorkingStatus',
            6 => 'zh-hk.ClientFinancialStatus',
            7 => 'zh-hk.ClientInvestmentOrientation',
            8 => 'zh-hk.ClientEvaluationResults',
            9 => 'zh-hk.OtherDeclarations',
            10 => 'zh-hk.RiskDisclosure',
            11 => 'zh-hk.Signature',
            12 => 'zh-hk.BusinessType',
            13 => 'zh-hk.DepositMethods',
            14 => 'zh-hk.DepositProof',
            15 => 'zh-hk.FinishOpeningAccount',
        ],
        'zh-cn' => [
            1 => 'zh-cn.HaveOtherBankCard',
            'WithOtherBankCard' => [
                2 => 'zh-cn.WithOtherBankCard.Agreement',
                3 => 'zh-cn.WithOtherBankCard.ClientIDCard',
                4 => 'zh-cn.WithOtherBankCard.ClientMainlandBankCard',
                5 => 'zh-cn.WithOtherBankCard.ClientOtherBankCard',
                6 => 'zh-cn.WithOtherBankCard.ClientWorkingStatus',
                7 => 'zh-cn.WithOtherBankCard.ClientFinancialStatus',
                8 => 'zh-cn.WithOtherBankCard.ClientInvestmentOrientation',
                9 => 'zh-cn.WithOtherBankCard.ClientEvaluationResults',
                10 => 'zh-cn.WithOtherBankCard.OtherDeclarations',
                11 => 'zh-cn.WithOtherBankCard.RiskDisclosure',
                12 => 'zh-cn.WithOtherBankCard.LiveDetection',
                13 => 'zh-cn.WithOtherBankCard.LiveDetectionResult',
                14 => 'zh-cn.WithOtherBankCard.Signature',
                15 => 'zh-cn.WithOtherBankCard.CACert',
                16 => 'zh-cn.WithOtherBankCard.BusinessType',
                17 => 'zh-cn.WithOtherBankCard.DepositMethods',
                18 => 'zh-cn.WithOtherBankCard.DepositProof',
                19 => 'zh-cn.WithOtherBankCard.FinishOpeningAccount',
            ],
            'WithHKBankCard' => [
                2 => 'zh-cn.WithHKBankCard.Agreement',
                3 => 'zh-cn.WithHKBankCard.ClientIDCard',
                4 => 'zh-cn.WithHKBankCard.ClientHKBankCard',
                5 => 'zh-cn.WithHKBankCard.ClientWorkingStatus',
                6 => 'zh-cn.WithHKBankCard.ClientFinancialStatus',
                7 => 'zh-cn.WithHKBankCard.ClientInvestmentOrientation',
                8 => 'zh-cn.WithHKBankCard.ClientEvaluationResults',
                9 => 'zh-cn.WithHKBankCard.OtherDeclarations',
                10 => 'zh-cn.WithHKBankCard.RiskDisclosure',
                11 => 'zh-cn.WithHKBankCard.Signature',
                12 => 'zh-cn.WithHKBankCard.BusinessType',
                13 => 'zh-cn.WithHKBankCard.DepositMethods',
                14 => 'zh-cn.WithHKBankCard.DepositProof',
                15 => 'zh-cn.WithHKBankCard.FinishOpeningAccount',
            ],
        ],
        'others' => [
            1 => 'others.Agreement',
            2 => 'others.ClientIDCard',
            3 => 'others.AddressProof',
            4 => 'others.ClientOtherBankCard',
            5 => 'others.ClientWorkingStatus',
            6 => 'others.ClientFinancialStatus',
            7 => 'others.ClientInvestmentOrientation',
            8 => 'others.ClientEvaluationResults',
            9 => 'others.OtherDeclarations',
            10 => 'others.RiskDisclosure',
            11 => 'others.Signature',
            12 => 'others.BusinessType',
            13 => 'others.DepositMethods',
            14 => 'others.DepositProof',
            15 => 'others.ClientWitness',
            16 => 'others.FinishOpeningAccount',
        ],
        'HaveOtherBankCard' => [
            'zh-cn' => 1,
        ],
        'Agreement' => [
            'zh-hk' => 1,
            'zh-cn' => [
                'WithHKBankCard' => 2,
                'WithOtherBankCard' => 2,
            ],
            'others' => 1,
        ],
        'ClientIDCard' => [
            'zh-hk' => 2,
            'zh-cn' => [
                'WithHKBankCard' => 3,
                'WithOtherBankCard' => 3,
            ],
            'others' => 2,
        ],
        'AddressProof' => [
            'zh-hk' => 3,
            'others' => 3,
        ],
        'ClientMainlandBankCard' => [
            'zh-cn' => [
                'WithOtherBankCard' => 4,
            ],
        ],
        'ClientHKBankCard' => [
            'zh-hk' => 4,
            'zh-cn' => [
                'WithHKBankCard' => 4,
            ],
        ],
        'ClientOtherBankCard' => [
            'zh-cn' => [
                'WithOtherBankCard' => 5,
            ],
            'others' => 4,
        ],
        'ClientWorkingStatus' => [
            'zh-hk' => 5,
            'zh-cn' => [
                'WithOtherBankCard' => 6,
                'WithHKBankCard' => 5,
            ],
            'others' => 5,
        ],
        'ClientFinancialStatus' => [
            'zh-hk' => 6,
            'zh-cn' => [
                'WithOtherBankCard' => 7,
                'WithHKBankCard' => 6,
            ],
            'others' => 6,
        ],
        'ClientInvestmentOrientation' => [
            'zh-hk' => 7,
            'zh-cn' => [
                'WithOtherBankCard' => 8,
                'WithHKBankCard' => 7,
            ],
            'others' => 7,
        ],
        'ClientEvaluationResults' => [
            'zh-hk' => 8,
            'zh-cn' => [
                'WithOtherBankCard' => 9,
                'WithHKBankCard' => 8,
            ],
            'others' => 8,
        ],
        'OtherDeclarations' => [
            'zh-hk' => 9,
            'zh-cn' => [
                'WithOtherBankCard' => 10,
                'WithHKBankCard' => 9,
            ],
            'others' => 9,
        ],
        'RiskDisclosure' => [
            'zh-hk' => 10,
            'zh-cn' => [
                'WithOtherBankCard' => 11,
                'WithHKBankCard' => 10,
            ],
            'others' => 10,
        ],
        'LiveDetection' => [
            'zh-cn' => [
                'WithOtherBankCard' => 12,
            ],
        ],
        'LiveDetectionResult' => [
            'zh-cn' => [
                'WithOtherBankCard' => 13,
            ],
        ],
        'Signature' => [
            'zh-hk' => 11,
            'zh-cn' => [
                'WithHKBankCard' => 11,
                'WithOtherBankCard' => 14,
            ],
            'others' => 11,
        ],
        'CACert' => [
            'zh-cn' => [
                'WithOtherBankCard' => 15,
            ],
        ],
        'BusinessType' => [
            'zh-hk' => 12,
            'zh-cn' => [
                'WithHKBankCard' => 12,
                'WithOtherBankCard' => 16,
            ],
            'others' => 12,
        ],
        'DepositMethods' => [
            'zh-hk' => 13,
            'zh-cn' => [
                'WithHKBankCard' => 13,
                'WithOtherBankCard' => 17,
            ],
            'others' => 13,
        ],
        'DepositProof' => [
            'zh-hk' => 14,
            'zh-cn' => [
                'WithHKBankCard' => 14,
                'WithOtherBankCard' => 18,
            ],
            'others' => 14,
        ],
        'ClientWitness' => [
            'others' => 15,
        ],
        'FinishOpeningAccount' => [
            'zh-hk' => 15,
            'zh-cn' => [
                'WithHKBankCard' => 15,
                'WithOtherBankCard' => 19,
            ],
            'others' => 16,
        ],
    ],
];
