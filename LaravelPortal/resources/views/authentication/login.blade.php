@extends('app')

@section('pagetitle', 'Sign In')
@section('bodyclass', 'auth-body')

@section('content')
    <div class="auth-wrap">

        {{-- ===== Left visual / branding panel ===== --}}
        <div class="auth-visual">
            <span class="blob b1"></span>
            <span class="blob b2"></span>
            <span class="blob b3"></span>

            <div class="v-brand">
                <div class="brand-icon"><i class="bi bi-activity"></i></div>
                <div>
                    <strong>I D C</strong>
                    <small>Invasive Ductal Carcinoma Portal</small>
                </div>
            </div>

            <h1>Precision diagnostics,<br>powered by <span class="grad-text">Artificial Intelligence</span></h1>
            <p class="v-sub">
                A unified clinical workspace for administrators, laboratory technicians and pathologists —
                from sample intake to AI-assisted histopathology results.
            </p>

            <div class="auth-feature">
                <div class="f-icon"><i class="bi bi-cpu"></i></div>
                <div>
                    <div class="f-title">Deep-learning IDC detection</div>
                    <div class="f-text">Histopathology image analysis assists pathologists in identifying invasive ductal carcinoma.</div>
                </div>
            </div>
            <div class="auth-feature">
                <div class="f-icon"><i class="bi bi-people"></i></div>
                <div>
                    <div class="f-title">Role-based clinical workflow</div>
                    <div class="f-text">Dedicated dashboards for Admin, Laboratory Technician and Pathologist teams.</div>
                </div>
            </div>
            <div class="auth-feature">
                <div class="f-icon"><i class="bi bi-envelope-check"></i></div>
                <div>
                    <div class="f-title">Automated patient notifications</div>
                    <div class="f-text">Patients receive instant email updates at registration and result stages.</div>
                </div>
            </div>
        </div>

        {{-- ===== Right form panel ===== --}}
        <div class="auth-form-side">
            <div class="auth-card">
                <div class="a-head">
                    <div class="brand-icon"><i class="bi bi-activity"></i></div>
                    <h4>Welcome back</h4>
                    <div class="a-sub">Sign in to the IDC clinical portal</div>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        @php flash()->addWarning($error); @endphp
                    @endforeach
                @endif

                <form action="{{ route('Page.login_auth') }}" method="post" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-icon-group">
                            <i class="bi bi-person"></i>
                            <input class="form-control" name="Username" type="text" required
                                placeholder="Enter your username" maxlength="30">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-icon-group">
                            <i class="bi bi-shield-lock"></i>
                            <input class="form-control" name="Password" type="password" required
                                placeholder="Enter your password" maxlength="30" id="loginPassword"
                                data-capslock-watch="#capsWarn">
                            <button type="button" class="toggle-password" tabindex="-1" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="caps-warn" id="capsWarn"><i class="bi bi-exclamation-triangle"></i> Caps Lock is on</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Sign in as</label>
                        <div class="role-picker">
                            <input type="radio" name="Role" value="1" id="roleAdmin" required>
                            <label for="roleAdmin"><i class="bi bi-shield-check"></i>Admin</label>

                            <input type="radio" name="Role" value="2" id="roleLT">
                            <label for="roleLT"><i class="bi bi-eyedropper"></i>Lab Technician</label>

                            <input type="radio" name="Role" value="3" id="rolePath">
                            <label for="rolePath"><i class="bi bi-clipboard2-pulse"></i>Pathologist</label>
                        </div>
                    </div>

                    <button class="btn btn-gradient btn-login" type="submit">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In Securely
                    </button>
                </form>

                <div class="auth-foot">
                    <i class="bi bi-lock-fill me-1"></i> Protected clinical environment · Authorized personnel only
                </div>
            </div>
        </div>
    </div>
@endsection
