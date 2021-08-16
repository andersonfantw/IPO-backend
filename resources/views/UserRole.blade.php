@extends('layouts.app')

@section('content')
    <user-role :columns="'{{ $columns }}'">
    </user-role>
@endsection
