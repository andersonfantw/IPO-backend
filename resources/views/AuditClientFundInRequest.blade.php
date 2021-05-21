@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶存款申請</h1>
    <audit-client-fund-in-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}"
        :action="'{{ route('DoAuditClientFundInRequest') }}'"
        :receipt="'{{ route('LoadReceipt', ['id' => $Request_ID]) }}'"
        :bank_card="'{{ route('LoadBankcard', ['id' => $Request_ID]) }}'" />
@endsection
