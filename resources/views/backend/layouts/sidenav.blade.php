<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard Panel</li>
            <li class="active"><a class="nav-link " href="{{route('dashboard')}}"><i
                        class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-clipboard"></i><span>Masters</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('building.index')}}">Data Gedung</a></li>
                    @if (auth()->user()->section_id == 128)
                        <li><a class="nav-link" href="{{route('section.index')}}">Daftar Section</a></li>
                        <li><a class="nav-link" href="{{route('user.index')}}">Daftar Departemen</a></li>
                        <li><a class="nav-link" href="{{route('energy.index')}}">Jenis Energi</a></li>
                        <li><a class="nav-link" href="{{route('index_legalitas.item')}}">Item Legalitas Infrastruktur</a></li>
                        <li><a class="nav-link" href="{{route('konservasi.index')}}">Konservasi Energi</a></li>
                    @endif
                </ul>
            </li>
            @if (auth()->user()->section_id != 128)
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Audit Input</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('civitas.index')}}">Civitas Akademika</a></li>
                    <li><a class="nav-link" href="{{route('legalitas.index')}}">Legalitas Infrastruktur</a></li>
                    <li><a class="nav-link" href="{{route('infrastruktur.index')}}">Penggunaan Infrastruktur</a></li>
                    <li><a class="nav-link" href="{{route('energy-usage.index')}}">Penggunaan Energi</a></li>
                    <li><a class="nav-link" href="{{route('konservasi_usage.index')}}">Konservasi Energi</a></li>
                    <li><a class="nav-link" href="{{route('measurement.index')}}">Kualitas Daya</a></li>
                </ul>
            </li>
            @else
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Rekap Audit</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('civitas.index')}}">Civitas Akademika</a></li>
                    <li><a class="nav-link" href="{{route('legalitas.index_admin')}}">Legalitas Infrastruktur</a></li>
                    <li><a class="nav-link" href="{{route('infrastruktur.index')}}">Penggunaan Infrastruktur</a></li>
                    <li><a class="nav-link" href="{{route('energy-usage.index_admin')}}">Penggunaan Energi</a></li>
                    <li><a class="nav-link" href="{{route('konservasi_usage.index_admin')}}">Konservasi Energi</a></li>
                    <li><a class="nav-link" href="{{route('measurement.index_admin')}}">Kualitas Daya</a></li>
                </ul>
            </li>
            @endif
        </ul>
    </aside>
</div>