@extends('layouts.app')

@section('content')
    <client-credit-cards :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientCreditCard') }}'"
        :view_request_url="'{{ route('ViewClientCreditCard') }}'" />
@endsection
