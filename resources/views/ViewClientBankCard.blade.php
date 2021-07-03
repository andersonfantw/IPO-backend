@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">已審核添加銀行卡申請</h1>
    <view-client-bank-card :client="'{{ $Client }}'" :client_bank_card="'{{ $ClientBankCard }}'"
        :client_id_card="'{{ $ClientIDCard }}'"
        :bank_card_image="'{{ route('LoadBankcard', ['id' => $ClientBankCardID]) }}'" />
@endsection
