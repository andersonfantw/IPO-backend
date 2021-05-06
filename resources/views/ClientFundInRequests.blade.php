@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶存款申請</h1>
    <client-fund-in-requests :columns="'{{ $columns }}'" :filter_match_mode="'{{ $filterMatchMode }}'"
        :audit_request_url="'{{ route('AuditClientFundInRequest') }}'"
        :view_request_url="'{{ route('ViewClientFundInRequest') }}'" />
@endsection
