@extends('layouts.app')

@section('content')
    <h1 class="text-warning text-center">開戶信發送清單</h1>
    <sending-email-list :p_columns="'{{ $columns }}'" :p_filter-match-mode="'{{ $filterMatchMode }}'"
        :user="'{{ $User }}'">
    </sending-email-list>
@endsection
