@extends('layouts.app')

@section('content')
    <deliverable-list2 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :generate_ayers_account_url="'{{ route('GenerateAyersAccount') }}'"
        :view_client_url="'{{ route('ViewClient') }}'">
        <template v-slot:menu>
            <side-menu :menus="{{ $menu }}" :current_url="'{{ url()->current() }}'"></side-menu>
        </template>
    </deliverable-list2>
@endsection
