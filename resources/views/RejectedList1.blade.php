@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">资料驳回清单</h1>
    <rejected-list1 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
    </rejected-list1>
@endsection
