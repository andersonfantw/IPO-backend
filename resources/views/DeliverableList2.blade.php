@extends('layouts.app')

@section('content')
    <deliverable-list2 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :generate_ayers_account_url="'{{ route('GenerateAyersAccount') }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
    </deliverable-list2>
@endsection
