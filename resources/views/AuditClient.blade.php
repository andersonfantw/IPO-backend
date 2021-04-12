@extends('layouts.app')

@section('content')
    <audit-client :idcard_face="'{{ route('LoadIDCardFace', ['uuid' => $uuid]) }}'"
        :idcard_back="'{{ route('LoadIDCardBack', ['uuid' => $uuid]) }}'" :銀行卡s="{{ $ClientBankCards }}"
        :hk_backcard_face="'{{ route('LoadHKBankCard', ['uuid' => $uuid]) }}'"
        :cn_backcard_face="'{{ route('LoadCNBankCard', ['uuid' => $uuid]) }}'"
        :name_card_face="'{{ route('LoadNameCard', ['uuid' => $uuid]) }}'"
        :deposit_proof="'{{ route('LoadDepositProof', ['uuid' => $uuid]) }}'"
        :address_proof="'{{ route('LoadAddressProof', ['uuid' => $uuid]) }}'" :action="'{{ route('audit1') }}'"
        :redirect_route="'{{ $redirect_route }}'" :next_status="'{{ $next_status }}'" :client="'{{ $Client }}'"
        :client_id_card="'{{ $ClientIDCard }}'" :client_address_proof="'{{ $ClientAddressProof }}'"
        :client_working_status="'{{ $ClientWorkingStatus }}'"
        :client_financial_status="'{{ $ClientFinancialStatus }}'"
        :client_investment_experience="'{{ $ClientInvestmentExperience }}'" :client_score="{{ $ClientScore }}"
        :client_evaluation_results="'{{ $ClientEvaluationResults }}'" :client_signature="'{{ $ClientSignature }}'"
        :client_business_type="'{{ $ClientBusinessType }}'" :client_deposit_proof="'{{ $ClientDepositProof }}'"
        :introducer="'{{ $Introducer }}'">
    </audit-client>
@endsection
