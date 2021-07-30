@extends('layouts.app')

@section('content')
    <client-overseas-fund-out-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientOverseasFundOutRequest') }}'"
        :view_request_url="'{{ route('ViewClientOverseasFundOutRequest') }}'" />
@endsection
