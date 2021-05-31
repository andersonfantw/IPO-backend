@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">添加銀行卡申請</h1>
    <client-bank-cards :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientFundInRequest') }}'"
        :view_request_url="'{{ route('ViewClientFundInRequest') }}'" />
@endsection
