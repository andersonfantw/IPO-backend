@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">已審核客戶香港出款申請</h1>
    <view-client-hk-fund-out-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}" />
@endsection
