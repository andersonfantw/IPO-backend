@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">二審資料可投遞清單</h1>
    <deliverable-list2 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :generate_ayers_account_url="'{{ route('GenerateAyersAccount') }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
    </deliverable-list2>
@endsection
