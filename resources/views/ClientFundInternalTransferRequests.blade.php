@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶內部轉帳申請</h1>
    <client-fund-internal-transfer-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientFundInternalTransferRequest') }}'"
        :view_request_url="'{{ route('ViewClientFundInternalTransferRequest') }}'" />
@endsection
