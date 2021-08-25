@extends('layouts.app')

@section('content')
    <sending-email-list :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :user="'{{ $User }}'">
        <template v-slot:menu>
            <side-menu :menus="{{ $menu }}" :current_url="'{{ url()->current() }}'"></side-menu>
        </template>
    </sending-email-list>
@endsection
