@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">已審核客戶存款申請</h1>
    <view-client-fund-in-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}"
        :receipt="'{{ route('LoadFundInReceipt', ['id' => $Request_ID]) }}'"
        :bank_card="'{{ route('LoadFundInBankCard', ['id' => $Request_ID]) }}'" />
@endsection
