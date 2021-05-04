@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">客戶海外出款申請</h1>
    <client-overseas-fund-out-requests :columns="'{{ $columns }}'" :filter_match_mode="'{{ $filterMatchMode }}'"
        :audit_request_url="'{{ route('AuditClientOverseasFundOutRequest') }}'"
        :view_request_url="'{{ route('ViewClientOverseasFundOutRequest') }}'" />
@endsection
