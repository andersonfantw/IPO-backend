<?php return [
    'Home' => [
        'next' => 'ChooseRegion',
        'previous' => 'Home',
    ],
    'ChooseRegion' => [
        'previous' => 'Home',
        'next' => [
            'zh-hk' => 'zh-hk.VerifyEmailAndMobile',
            'zh-cn' => 'zh-cn.VerifyEmailAndMobile',
        ],
    ],
    'VerifyEmailAndMobile' => [
        'previous' => [
            'zh-hk' => 'ChooseRegion',
            'zh-cn' => 'ChooseRegion',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.Agreement',
            'zh-cn' => 'zh-cn.Agreement',
        ],
    ],
    'Agreement' => [
        'previous' => [
            'zh-hk' => 'zh-hk.VerifyEmailAndMobile',
            'zh-cn' => 'zh-cn.VerifyEmailAndMobile',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientIDCard',
            'zh-cn' => 'zh-cn.ClientIDCard',
        ],
    ],
    'ClientIDCard' => [
        'previous' => [
            'zh-hk' => 'zh-hk.Agreement',
            'zh-cn' => 'zh-cn.Agreement',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.AddressProof',
            'zh-cn' => 'zh-cn.ClientMainlandBankCard',
        ],
    ],
    'AddressProof' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientIDCard',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientHKBankCard',
        ],
    ],
    'ClientMainlandBankCard' => [
        'previous' => [
            'zh-cn' => 'zh-cn.ClientIDCard',
        ],
        'next' => [
            'zh-cn' => 'zh-cn.ClientHKBankCard',
        ],
    ],
    'ClientHKBankCard' => [
        'previous' => [
            'zh-hk' => 'zh-hk.AddressProof',
            'zh-cn' => 'zh-cn.ClientMainlandBankCard',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientWorkingStatus',
            'zh-cn' => 'zh-cn.ClientWorkingStatus',
        ],
    ],
    'ClientWorkingStatus' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientHKBankCard',
            'zh-cn' => 'zh-cn.ClientHKBankCard',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientFinancialStatus',
            'zh-cn' => 'zh-cn.ClientFinancialStatus',
        ],
    ],
    'ClientFinancialStatus' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientWorkingStatus',
            'zh-cn' => 'zh-cn.ClientWorkingStatus',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientInvestmentOrientation',
            'zh-cn' => 'zh-cn.ClientInvestmentOrientation',
        ],
    ],
    'ClientInvestmentOrientation' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientFinancialStatus',
            'zh-cn' => 'zh-cn.ClientFinancialStatus',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientEvaluationResults',
            'zh-cn' => 'zh-cn.ClientEvaluationResults',
        ],
    ],
    'ClientEvaluationResults' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientInvestmentOrientation',
            'zh-cn' => 'zh-cn.ClientInvestmentOrientation',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.OtherDeclarations',
            'zh-cn' => 'zh-cn.OtherDeclarations',
        ],
    ],
    'OtherDeclarations' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientEvaluationResults',
            'zh-cn' => 'zh-cn.ClientEvaluationResults',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.RiskDisclosure',
            'zh-cn' => 'zh-cn.RiskDisclosure',
        ],
    ],
    'RiskDisclosure' => [
        'previous' => [
            'zh-hk' => 'zh-hk.OtherDeclarations',
            'zh-cn' => 'zh-cn.OtherDeclarations',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.Signature',
            'zh-cn' => 'zh-cn.LiveDetection',
        ],
    ],
    'LiveDetection' => [
        'previous' => [
            'zh-cn' => 'zh-cn.RiskDisclosure',
        ],
        'next' => [
            'zh-cn' => 'zh-cn.LiveDetectionResult',
        ],
    ],
    'LiveDetectionResult' => [
        'previous' => [
            'zh-cn' => 'zh-cn.LiveDetection',
        ],
        'next' => [
            'zh-cn' => 'zh-cn.Signature',
        ],
    ],
    'Signature' => [
        'previous' => [
            'zh-hk' => 'zh-hk.RiskDisclosure',
            'zh-cn' => 'zh-cn.LiveDetectionResult',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.BusinessType',
            'zh-cn' => 'zh-cn.CACert',
        ],
    ],
    'CACert' => [
        'previous' => [
            'zh-cn' => 'zh-cn.Signature',
        ],
        'next' => [
            'zh-cn' => 'zh-cn.BusinessType',
        ],
    ],
    'BusinessType' => [
        'previous' => [
            'zh-hk' => 'zh-hk.Signature',
            'zh-cn' => 'zh-cn.CACert',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.DepositMethods',
            'zh-cn' => 'zh-cn.DepositMethods',
        ],
    ],
    'DepositMethods' => [
        'previous' => [
            'zh-hk' => 'zh-hk.BusinessType',
            'zh-cn' => 'zh-cn.BusinessType',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.DepositProof',
            'zh-cn' => 'zh-cn.DepositProof',
        ],
    ],
    'DepositProof' => [
        'previous' => [
            'zh-hk' => 'zh-hk.DepositMethods',
            'zh-cn' => 'zh-cn.DepositMethods',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.FinishOpeningAccount',
            'zh-cn' => 'zh-cn.FinishOpeningAccount',
        ],
    ],
    'FinishOpeningAccount' => [
        'previous' => [
            'zh-hk' => 'zh-hk.DepositProof',
            'zh-cn' => 'zh-cn.DepositProof',
        ],
    ],
];
