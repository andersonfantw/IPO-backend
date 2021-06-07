@extends('layouts.app')

@section('content')
<input id="ar_id" type="hidden" value="{{$id}}" />
<account-report ipo_activity_period_id="{{$id}}"></account-report>
@endsection