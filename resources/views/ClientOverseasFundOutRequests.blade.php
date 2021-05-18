@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶海外出款申請</h1>
    <client-overseas-fund-out-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientOverseasFundOutRequest') }}'"
        :view_request_url="'{{ route('ViewClientOverseasFundOutRequest') }}'" />
@endsection
