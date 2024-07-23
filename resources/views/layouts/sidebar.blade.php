<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        {{-- @include('layouts.project_logo') --}}
        <span class="brand-text font-weight-light">
            {{--  {{ config('app.name') }}  --}}
            @include('layouts.project_main_logo')
        </span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
