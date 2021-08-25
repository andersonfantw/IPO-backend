@extends('layouts.app')

@section('content')
    <permission>
        <template v-slot:menu>
            <side-menu :menus="{{ $menu }}" :current_url="'{{ url()->current() }}'"></side-menu>
        </template>
    </permission>
@endsection
