@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">一审资料再审核清单</h1>
    <reaudit-list1 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </reaudit-list1>
@endsection
