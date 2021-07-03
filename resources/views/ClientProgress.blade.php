@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">開戶進度</h1>
    <client-progress :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'">
    </client-progress>
@endsection
