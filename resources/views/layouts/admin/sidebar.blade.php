
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.employees.index') }}">SPK</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.employees.index') }}">SPK</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Users</li>
            <li class="@if (request()->routeIs('admin.employees.*')) active @endif"><a class="nav-link" href="{{ route('admin.employees.index') }}"><i class="fas fa-users"></i> <span>Karyawan</span></a></li>
            <li class="menu-header">Calculation</li>
{{--            <li class="@if (request()->routeIs('admin.calcultions.simple-additive-weightings.*')) active @endif"><a class="nav-link" href="{{ route('admin.calcultions.simple-additive-weightings.index') }}"><i class="fa fa-leaf"></i> <span>SAW</span></a></li>--}}
{{--            <li class="@if (request()->routeIs('admin.calcultions.mooras.*')) active @endif"><a class="nav-link" href="{{ route('admin.calcultions.mooras.index') }}"><i class="fa fa-history"></i> <span>Moora</span></a></li>--}}
{{--            <li class="@if (request()->routeIs('admin.matrix.*')) active @endif"><a class="nav-link" href="{{ route('admin.matrix.index') }}"><i class="fas fa-list-ol"></i> <span>Matriks</span></a></li>--}}
{{--            <li class="@if (request()->routeIs('admin.normalizations.*')) active @endif"><a class="nav-link" href="{{ route('admin.normalizations.index') }}"><i class="fas fa-sort-numeric-down"></i> <span>Normalisasi</span></a></li>--}}
{{--            <li class="@if (request()->routeIs('admin.calculations.*')) active @endif"><a class="nav-link" href="{{ route('admin.calculations.index') }}"><i class="fas fa-trophy"></i> <span>Perhitungan</span></a></li>--}}
        </ul>
    </aside>
</div>
