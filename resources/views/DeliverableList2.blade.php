@extends('layouts.app')

@section('content')
    <h1 class="blue text-center">二审资料可投递清单</h1>
    <deliverable-list2 :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :generate_ayers_account_url="'{{ route('GenerateAyersAccount') }}'">
    </deliverable-list2>
@endsection
