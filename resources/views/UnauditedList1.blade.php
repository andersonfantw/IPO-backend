@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">一審資料未審核清單</h1>
    <unaudited-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </unaudited-list1>
@endsection
