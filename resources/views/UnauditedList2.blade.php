@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">二审资料未审核清单</h1>
    <unaudited-list2 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </unaudited-list2>
@endsection
