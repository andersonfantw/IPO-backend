@extends('layouts.app')

@section('content')
    <client-fund-in-requests :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientFundInRequest') }}'"
        :view_request_url="'{{ route('ViewClientFundInRequest') }}'" :issued_by="'{{ auth()->user()->name }}'" />
@endsection
