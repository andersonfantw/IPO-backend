@extends('layouts.app')

@section('content')
    <unaudited-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'" :base_url="'{{ secure_url('/') }}'">
    </unaudited-list1>
@endsection
