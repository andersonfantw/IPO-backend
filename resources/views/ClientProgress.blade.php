@extends('layouts.app')

@section('content')
    <client-progress :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'">
    </client-progress>
@endsection
