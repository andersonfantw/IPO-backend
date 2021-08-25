@extends('layouts.app')

@section('content')
    <rejected-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
        <template v-slot:menu>
            <side-menu :menus="{{ $menu }}" :current_url="'{{ url()->current() }}'"></side-menu>
        </template>
    </rejected-list1>
@endsection
