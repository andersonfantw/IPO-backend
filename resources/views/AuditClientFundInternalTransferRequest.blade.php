@extends('layouts.app')

@section('content')
    <view-client-fund-internal-transfer-request :request="'{{ $Request }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :ayers_accounts="{{ $AyersAccounts }}" />
@endsection
