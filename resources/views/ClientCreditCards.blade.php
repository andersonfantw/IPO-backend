@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">添加信用卡申請</h1>
    <client-credit-cards :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientCreditCard') }}'"
        :view_request_url="'{{ route('ViewClientCreditCard') }}'" />
@endsection
