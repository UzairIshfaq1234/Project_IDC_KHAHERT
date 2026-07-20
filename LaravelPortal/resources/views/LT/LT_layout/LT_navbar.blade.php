{{-- ===== Laboratory Technician sidebar ===== --}}
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
        @if (session('LT_Role_Image'))
            <img src="{{ asset('Admin_Images/' . session('LT_Role_Image')) }}" alt="user" class="avatar">
        @else
            <span class="avatar avatar-grad-3">{{ strtoupper(substr(session('LT_Auth_Session', 'L'), 0, 2)) }}</span>
        @endif
        <div>
            <div class="u-name">{{ session('LT_Auth_Session') }}</div>
            <div class="u-role">Lab Technician</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Laboratory</div>
        <a href="{{ route('LT.dashboard_page') }}"
            class="idc-nav-item {{ request()->routeIs('LT.dashboard_page') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Patients</div>
        <a href="{{ route('patient.add') }}" class="idc-nav-item {{ request()->routeIs('patient.add') ? 'active' : '' }}">
            <i class="bi bi-person-add"></i> Add Patients
        </a>
        <a href="{{ route('patient.allpatient') }}"
            class="idc-nav-item {{ request()->routeIs('patient.allpatient') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-data"></i> All Patients
        </a>
        <a href="{{ route('patient.calendar') }}"
            class="idc-nav-item {{ request()->routeIs('patient.calendar') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Submissions Calendar
        </a>
        <a href="{{ route('patient.scanner') }}"
            class="idc-nav-item {{ request()->routeIs('patient.scanner') ? 'active' : '' }}">
            <i class="bi bi-upc-scan"></i> Barcode Scanner
            <span class="nav-pill">NEW</span>
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
