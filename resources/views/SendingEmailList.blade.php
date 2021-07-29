@extends('layouts.app')

@section('content')
    <sending-email-list :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :user="'{{ $User }}'">
    </sending-email-list>
@endsection
