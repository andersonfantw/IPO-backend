@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶香港出款申請</h1>
    <audit-client-hk-fund-out-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}"
        :action="'{{ route('DoAuditClientHKFundOutRequest') }}'" />
@endsection
