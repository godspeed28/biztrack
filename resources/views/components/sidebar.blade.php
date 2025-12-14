<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo mt-3">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('images/biztrack-no-bg.png') }}" width="50" alt="">
            </span>
            <span class="app-brand-text demo fw-semibold p-1" style="color:darkslategray;">BizTrack</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        {{-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Without menu</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">Without navbar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-container.html" class="menu-link">
                        <div data-i18n="Container">Container</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-fluid.html" class="menu-link">
                        <div data-i18n="Fluid">Fluid</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-blank.html" class="menu-link">
                        <div data-i18n="Blank">Blank</div>
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        <li class="menu-item {{ Request::routeIs('account.settings.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Account Settings">Product & Stock</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('account.settings.account') ? 'active' : '' }}">
                    <a href="{{ route('account.settings.account') }}" class="menu-link">
                        <div data-i18n="Account">Produk</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('account.settings.connections') ? 'active' : '' }}">
                    <a href="{{ route('account.settings.connections') }}" class="menu-link">
                        <div data-i18n="Connections">Stok</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::routeIs('account.settings.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-transfer"></i>
                <div data-i18n="Account Settings">Transaksi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('account.settings.account') ? 'active' : '' }}">
                    <a href="{{ route('account.settings.account') }}" class="menu-link">
                        <div data-i18n="Account">Kasir</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('account.settings.connections') ? 'active' : '' }}">
                    <a href="{{ route('account.settings.connections') }}" class="menu-link">
                        <div data-i18n="Connections">Riwayat Transaksi</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::routeIs('account.settings.*') ? 'active open' : '' }}">
            <a href="{{ route('account.settings.account') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Account Settings">Laporan</div>
            </a>
        </li>

        <li class="menu-item {{ Request::routeIs('account.settings.*') ? 'active open' : '' }}">
            <a href="{{ route('account.settings.account') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Account Settings">Data Pendukung</div>
            </a>
        </li>

        <li class="menu-item {{ Request::routeIs('account.settings.*') ? 'active open' : '' }}">
            <a href="{{ route('account.settings.account') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Account Settings">Pengaturan</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
