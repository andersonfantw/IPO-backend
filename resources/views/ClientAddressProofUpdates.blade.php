@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶住址證明修改</h1>
    <client-address-proof-updates :columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_request_url="'{{ route('AuditClientAddressProofUpdate') }}'"
        :view_request_url="'{{ route('ViewClientAddressProofUpdate') }}'" />
@endsection
