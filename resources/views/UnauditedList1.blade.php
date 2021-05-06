@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">一審資料未審核清單</h1>
    <unaudited-list1 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </unaudited-list1>
@endsection
