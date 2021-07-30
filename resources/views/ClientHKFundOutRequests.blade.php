@extends('layouts.app')

@section('content')
    <client-hk-fund-out-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientHKFundOutRequest') }}'"
        :view_request_url="'{{ route('ViewClientHKFundOutRequest') }}'" :issued_by="'{{ auth()->user()->name }}'" />
@endsection
