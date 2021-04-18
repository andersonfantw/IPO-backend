<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .border {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        td {
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .normal-font {
            font-size: 75%;
        }

    </style>
</head>

<body>
    <p>{{ __('Email.1') }}</p>
    <p>{{ __('Email.2') }}</p>
    <p>{{ __('Email.3') }}</p>
    <p>
        <strong>{{ __('Email.4') }}</strong>{{ $account_name }}<br>
        <strong>{{ __('Email.5') }}</strong>{{ $account_no }}<br>
        <strong>{{ __('Email.6') }}</strong>{{ $account_type }}<br>
    </p>
    <p>{{ __('Email.7') }}</p>
    <table border="1">
        <thead>
            <tr>
                <th>
                    {{ __('Email.8') }}<br>{{ __('Email.9') }}
                </th>
                <th>
                    {{ __('Email.10') }}<br>{{ __('Email.11') }}
                </th>
                <th>
                    {{ __('Email.12') }}<br>{{ __('Email.13') }}
                </th>
                <th>
                    {{ __('Email.14') }}<br>{{ __('Email.15') }}
                </th>
                <th>
                    {{ __('Email.16') }}<br>{{ __('Email.17') }}
                </th>
                <th>
                    {{ __('Email.18') }}<br>{{ __('Email.19') }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3">
                    {{ __('Email.20') }}
                </td>
                <td rowspan="3">
                    {{ __('Email.21') }}
                </td>
                <td>
                    {{ __('Email.22') }}
                </td>
                <td>
                    {{ __('Email.25') }}
                </td>
                <td rowspan="3">
                    {{ __('Email.28') }}<br>{{ __('Email.29') }}
                </td>
                <td rowspan="3">
                    {{ __('Email.30') }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Email.23') }}
                </td>
                <td>
                    {{ __('Email.26') }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Email.24') }}
                </td>
                <td>
                    {{ __('Email.27') }}
                </td>
            </tr>
            <tr>
                <td rowspan="2">
                    {{ __('Email.31') }}
                </td>
                <td rowspan="2">
                    {{ __('Email.32') }}
                </td>
                <td>
                    {{ __('Email.33') }}
                </td>
                <td>
                    {{ __('Email.35') }}
                </td>
                <td rowspan="2">
                    {{ __('Email.37') }}<br>{{ __('Email.38') }}
                </td>
                <td rowspan="2">
                    {{ __('Email.39') }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Email.34') }}
                </td>
                <td>
                    {{ __('Email.36') }}
                </td>
            </tr>
        </tbody>
    </table>
    <p>
        {{ __('Email.40') }}{{ $account_no }}{{ __('Email.41') }}
    </p>
    <p>
        {{ __('Email.42') }}
    </p>
    <p>
        {{ __('Email.43') }}{{ $level }}{{ __('Email.44') }}{{ $risk_tolerance }}{{ __('Email.45') }}
    </p>
    <p>
        {{ __('Email.46') }}
    </p>
    <p>
        <strong>{{ __('Email.47') }}</strong><br>
        <strong>{{ __('Email.48') }}</strong><br>
        <strong>{{ __('Email.49') }}</strong><br>
        <strong>{{ __('Email.50') }}</strong><br>
    </p>
    <p>
        {{ __('Email.51') }}
    </p>
    <p style="text-align: center;">
        {{ __('Email.52') }}
    </p>
    <p style="text-align: center;">
        {{ __('Email.53') }}
    </p>
</body>

</html>
