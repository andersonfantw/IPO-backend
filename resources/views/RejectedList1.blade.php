@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">资料驳回清单</h1>
    <rejected-list1 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </rejected-list1>
@endsection
