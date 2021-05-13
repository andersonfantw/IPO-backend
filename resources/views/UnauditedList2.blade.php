@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">二審資料未審核清單</h1>
    <unaudited-list2 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
    </unaudited-list2>
@endsection
