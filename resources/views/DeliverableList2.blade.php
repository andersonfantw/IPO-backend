@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">二審資料可投遞清單</h1>
    <deliverable-list2 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :generate_ayers_account_url="'{{ route('GenerateAyersAccount') }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
    </deliverable-list2>
@endsection
