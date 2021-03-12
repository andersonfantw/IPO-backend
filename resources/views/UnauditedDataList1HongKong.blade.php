@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">一审资料未审核清单(香港)</h1>
    <unaudited-data-list1-hong-kong :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </unaudited-data-list1-hong-kong>
@endsection
