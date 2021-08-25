@extends('layouts.app')

@section('content')
    <unaudited-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'" :base_url="'{{ secure_url('/') }}'">
        <template v-slot:menu>
            <side-menu :menus="{{ $menu }}" :current_url="'{{ url()->current() }}'"></side-menu>
        </template>
    </unaudited-list1>
@endsection
