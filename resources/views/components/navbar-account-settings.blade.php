<ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('account.settings.account') ? 'active' : '' }}"
            href="{{ route('account.settings.account') }}">
            <i class="bx bx-user me-1"></i> Account
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('account.settings.notifications') ? 'active' : '' }}"
            href="{{ route('account.settings.notifications') }}">
            <i class="bx bx-bell me-1"></i> Notifications
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('account.settings.connections') ? 'active' : '' }}"
            href="{{ route('account.settings.connections') }}">
            <i class="bx bx-link-alt me-1"></i> Connections
        </a>
    </li>
</ul>
