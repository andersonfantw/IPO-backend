@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">已審核客戶海外出款申請</h1>
    <view-client-overseas-fund-out-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}" />
@endsection
