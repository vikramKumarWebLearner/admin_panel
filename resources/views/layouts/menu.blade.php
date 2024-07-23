@php
    $urlAdmin = config('fast.admin_prefix');
@endphp

@can('dashboard')
    @php
        $isDashboardActive = Request::is($urlAdmin);
    @endphp
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link {{ $isDashboardActive ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>@lang('menu.dashboard')</p>
        </a>
    </li>
@endcan

@can('dashboard')
    @php
        $isCategroyActive = Request::is($urlAdmin . '*categories*');
    @endphp
    <li class="nav-item">
        <a href="{{ route('categories.index') }}" class="nav-link {{ $isCategroyActive ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>@lang('menu.categories')</p>
        </a>
    </li>
@endcan

@canany(['users.index', 'roles.index', 'permissions.index'])
    @php
        $isUserActive = Request::is($urlAdmin . '*users*');
        $isRoleActive = Request::is($urlAdmin . '*roles*');
    @endphp
    <li class="nav-item {{ $isUserActive || $isRoleActive ? 'menu-open' : '' }} ">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shield-virus"></i>
            <p>
                @lang('menu.user.title')
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('users.index')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ $isUserActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            @lang('menu.user.users')
                        </p>
                    </a>
                </li>
            @endcan
            @can('roles.index')
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link {{ $isRoleActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            @lang('menu.user.roles')
                        </p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
