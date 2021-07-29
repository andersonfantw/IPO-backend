@extends('layouts.app')

@section('content')
    <client-bank-cards :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientBankCard') }}'"
        :view_request_url="'{{ route('ViewClientBankCard') }}'" />
@endsection
