@extends('layouts.app')

@section('content')
    <permission :columns="'{{ $columns }}'">
    </permission>
@endsection
