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
            'others' => 'others.VerifyEmailAndMobile',
        ],
    ],
    'VerifyEmailAndMobile' => [
        'previous' => [
            'zh-hk' => 'ChooseRegion',
            'zh-cn' => 'ChooseRegion',
            'others' => 'ChooseRegion',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.Agreement',
            'zh-cn' => 'zh-cn.Agreement',
            'others' => 'others.Agreement',
        ],
    ],
    'Agreement' => [
        'previous' => [
            'zh-hk' => 'zh-hk.VerifyEmailAndMobile',
            'zh-cn' => 'zh-cn.VerifyEmailAndMobile',
            'others' => 'others.VerifyEmailAndMobile',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientIDCard',
            'zh-cn' => 'zh-cn.ClientIDCard',
            'others' => 'others.ClientIDCard',
        ],
    ],
    'ClientIDCard' => [
        'previous' => [
            'zh-hk' => 'zh-hk.Agreement',
            'zh-cn' => 'zh-cn.Agreement',
            'others' => 'others.Agreement',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.AddressProof',
            'zh-cn' => 'zh-cn.ClientMainlandBankCard',
            'others' => 'others.AddressProof',
        ],
    ],
    'AddressProof' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientIDCard',
            'others' => 'others.ClientIDCard',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientHKBankCard',
            'others' => 'others.ClientOtherBankCard',
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
    'ClientOtherBankCard' => [
        'previous' => [
            'others' => 'others.AddressProof',
        ],
        'next' => [
            'others' => 'others.ClientWorkingStatus',
        ],
    ],
    'ClientWorkingStatus' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientHKBankCard',
            'zh-cn' => 'zh-cn.ClientHKBankCard',
            'others' => 'others.ClientOtherBankCard',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientFinancialStatus',
            'zh-cn' => 'zh-cn.ClientFinancialStatus',
            'others' => 'others.ClientFinancialStatus',
        ],
    ],
    'ClientFinancialStatus' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientWorkingStatus',
            'zh-cn' => 'zh-cn.ClientWorkingStatus',
            'others' => 'others.ClientWorkingStatus',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientInvestmentOrientation',
            'zh-cn' => 'zh-cn.ClientInvestmentOrientation',
            'others' => 'others.ClientInvestmentOrientation',
        ],
    ],
    'ClientInvestmentOrientation' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientFinancialStatus',
            'zh-cn' => 'zh-cn.ClientFinancialStatus',
            'others' => 'others.ClientFinancialStatus',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.ClientEvaluationResults',
            'zh-cn' => 'zh-cn.ClientEvaluationResults',
            'others' => 'others.ClientEvaluationResults',
        ],
    ],
    'ClientEvaluationResults' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientInvestmentOrientation',
            'zh-cn' => 'zh-cn.ClientInvestmentOrientation',
            'others' => 'others.ClientInvestmentOrientation',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.OtherDeclarations',
            'zh-cn' => 'zh-cn.OtherDeclarations',
            'others' => 'others.OtherDeclarations',
        ],
    ],
    'OtherDeclarations' => [
        'previous' => [
            'zh-hk' => 'zh-hk.ClientEvaluationResults',
            'zh-cn' => 'zh-cn.ClientEvaluationResults',
            'others' => 'others.ClientEvaluationResults',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.RiskDisclosure',
            'zh-cn' => 'zh-cn.RiskDisclosure',
            'others' => 'others.RiskDisclosure',
        ],
    ],
    'RiskDisclosure' => [
        'previous' => [
            'zh-hk' => 'zh-hk.OtherDeclarations',
            'zh-cn' => 'zh-cn.OtherDeclarations',
            'others' => 'others.OtherDeclarations',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.Signature',
            'zh-cn' => 'zh-cn.LiveDetection',
            'others' => 'others.Signature',
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
            'others' => 'others.RiskDisclosure',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.BusinessType',
            'zh-cn' => 'zh-cn.CACert',
            'others' => 'others.BusinessType',
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
            'others' => 'others.Signature',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.DepositMethods',
            'zh-cn' => 'zh-cn.DepositMethods',
            'others' => 'others.DepositMethods',
        ],
    ],
    'DepositMethods' => [
        'previous' => [
            'zh-hk' => 'zh-hk.BusinessType',
            'zh-cn' => 'zh-cn.BusinessType',
            'others' => 'others.BusinessType',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.DepositProof',
            'zh-cn' => 'zh-cn.DepositProof',
            'others' => 'others.DepositProof',
        ],
    ],
    'DepositProof' => [
        'previous' => [
            'zh-hk' => 'zh-hk.DepositMethods',
            'zh-cn' => 'zh-cn.DepositMethods',
            'others' => 'others.DepositMethods',
        ],
        'next' => [
            'zh-hk' => 'zh-hk.FinishOpeningAccount',
            'zh-cn' => 'zh-cn.FinishOpeningAccount',
            'others' => 'others.FinishOpeningAccount',
        ],
    ],
    'FinishOpeningAccount' => [
        'previous' => [
            'zh-hk' => 'zh-hk.DepositProof',
            'zh-cn' => 'zh-cn.DepositProof',
            'others' => 'others.DepositProof',
        ],
    ],
];
