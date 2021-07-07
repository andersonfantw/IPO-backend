@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">添加銀行卡申請</h1>
    <audit-client-credit-card :client="'{{ $Client }}'" :client_credit_card="'{{ $ClientCreditCard }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :action="'{{ route('DoAuditClientCreditCard') }}'"
        :credit_card_image="'{{ route('LoadCreditCard', ['id' => $ClientCreditCardID]) }}'" />
@endsection
