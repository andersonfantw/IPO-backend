@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">添加銀行卡申請</h1>
    <audit-client-bank-card :client="'{{ $Client }}'" :client_bank_card="'{{ $ClientBankCard }}'"
        :client_id_card="'{{ $ClientIDCard }}'"
        :bank_card_image="'{{ route('LoadBankCard', ['id' => $ClientBankCardID]) }}'" />
@endsection
