@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">銀盛信用卡出款申請</h1>
    <client-credit-card-fund-out-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientCreditCardFundOutRequest') }}'"
        :view_request_url="'{{ route('ViewClientCreditCardFundOutRequest') }}'" />
@endsection
