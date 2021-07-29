@extends('layouts.app')

@section('content')
    <rejected-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
    </rejected-list1>
@endsection
