@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">已審核客戶內部轉帳申請</h1>
    <view-client-fund-internal-transfer-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}" />
@endsection
