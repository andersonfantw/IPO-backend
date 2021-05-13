@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">資料駁回清單</h1>
    <rejected-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
    </rejected-list1>
@endsection
