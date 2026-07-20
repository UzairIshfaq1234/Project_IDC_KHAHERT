{{-- ===== Pathologist sidebar ===== --}}
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<aside class="idc-sidebar" id="idcSidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-activity"></i></div>
        <div class="brand-text">
            <strong>I D C</strong>
            <small>Cancer Detection</small>
        </div>
    </div>

    <div class="sidebar-user">
        @if (session('Path_Role_image'))
            <img src="{{ asset('Admin_Images/' . session('Path_Role_image')) }}" alt="user" class="avatar">
        @else
            <span class="avatar avatar-grad-2">{{ strtoupper(substr(session('Path_Auth_Session', 'P'), 0, 2)) }}</span>
        @endif
        <div>
            <div class="u-name">{{ session('Path_Auth_Session') }}</div>
            <div class="u-role">Pathologist</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Pathology</div>
        <a href="{{ route('Path.dashboard_page') }}"
            class="idc-nav-item {{ request()->routeIs('Path.dashboard_page') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Clinical Work</div>
        <a href="{{ route('Path.Appointments') }}"
            class="idc-nav-item {{ request()->routeIs('Path.Appointments') ? 'active' : '' }}">
            <i class="bi bi-calendar2-check"></i> Appointments
        </a>
        <a href="{{ route('patient.calendar') }}"
            class="idc-nav-item {{ request()->routeIs('patient.calendar') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Submissions Calendar
        </a>
        <a href="http://127.0.0.1:5000/" target="_blank" class="idc-nav-item">
            <i class="bi bi-cpu"></i> AI Detection Engine
            <span class="nav-pill">AI</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('profile.my') }}" class="idc-nav-item {{ request()->routeIs('profile.my') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
        <a href="{{ route('Page.logout') }}" class="idc-nav-item">
            <i class="bi bi-box-arrow-right"></i> Sign Out
        </a>
    </div>
</aside>
