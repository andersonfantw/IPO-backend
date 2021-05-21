@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶海外出款申請</h1>
    <audit-client-overseas-fund-out-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}"
        :action="'{{ route('DoAuditClientOverseasFundOutRequest') }}'" />
@endsection
