@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">客戶住址證明修改</h1>
    <audit-client-address-proof-update :client="'{{ $Client }}'" :client_id_card="'{{ $ClientIDCard }}'"
        :client_address_proof="'{{ $ClientAddressProof }}'"
        :client_address_proof_update="'{{ $ClientAddressProofUpdate }}'"
        :redirect_route="'{{ route('ClientAddressProofUpdates') }}'"
        :action="'{{ route('AuditClientAddressProofUpdate') }}'"
        :old_address_proof_image="'{{ route('LoadAddressProof', ['id' => $AddressProofID]) }}'"
        :new_address_proof_image="'{{ route('LoadAddressProofUpdate', ['id' => $AddressProofUpdateID]) }}'" />
@endsection
