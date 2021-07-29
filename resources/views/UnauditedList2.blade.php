@extends('layouts.app')

@section('content')
    <unaudited-list2 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </unaudited-list2>
@endsection
