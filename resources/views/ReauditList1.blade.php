@extends('layouts.app')

@section('content')
    <reaudit-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </reaudit-list1>
@endsection
