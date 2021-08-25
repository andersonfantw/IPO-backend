@extends('layouts.app')

@section('content')
    <reaudit-list1 :p_columns="'{{ $columns }}'" :filter_type="'{{ $FilterType }}'"
        :audit_client_url="'{{ route('AuditClient') }}'">
        <template v-slot:menu>
            <side-menu :menus="{{ $menu }}" :current_url="'{{ url()->current() }}'"></side-menu>
        </template>
    </reaudit-list1>
@endsection
