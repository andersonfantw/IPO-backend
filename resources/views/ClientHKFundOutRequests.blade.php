@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶香港出款申請</h1>
    <client-hk-fund-out-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientHKFundOutRequest') }}'"
        :view_request_url="'{{ route('ViewClientHKFundOutRequest') }}'" />
@endsection
