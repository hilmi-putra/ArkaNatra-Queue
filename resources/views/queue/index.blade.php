<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Check your work order queue status and estimation at ArkaNatra.">
    <title>ArkaNatra - Queue Status</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dq0bylaa7/image/upload/v1764391033/AC_LOGO_1_v85q1j.png">

    <!-- CSS Preline -->
    <link rel="stylesheet" href="https://preline.co/assets/css/main.css?v=3.0.1">

    <link rel="stylesheet" href="{{ asset('css/queue.css') }}">
</head>

<body>
    <div class="layout-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div class="flex gap-3">
                        <img src="https://res.cloudinary.com/dhjqjn2hn/image/upload/v1763543841/logo-arka_nvpc2s.png"
                            alt="" class="shrink-0 size-8" width="36" height="36">
                        <h1 class="text-lg font-semibold">Check Your Queue</h1>
                    </div>

                    <p>Enter your Reference ID and personal token to see the live status and estimation of your work
                        order.</p>
                </div>

                <div class="form-container">
                    <form action="{{ route('queue.check') }}" method="POST" id="queueForm">
                        @csrf

                        <div class="form-group">
                            <label for="ref_id" class="form-label">Reference ID</label>
                            <input type="text" id="ref_id" name="ref_id" value="{{ old('ref_id') }}" required
                                class="form-input" placeholder="e.g., WO-20251124-O7CGiK"
                                pattern="WO-\d{8}-[A-Za-z0-9]{6}"
                                title="Format: WO-YYYYMMDD-XXXXXX (contoh: WO-20251124-O7CGiK)" maxlength="20">
                            <div class="validation-feedback" id="refIdFeedback"></div>
                            <small class="form-hint">Format: WO-YYYYMMDD-XXXXXX</small>
                        </div>

                        <div class="form-group">
                            <label for="token" class="form-label">Your Token</label>
                            <input type="text" id="token" name="token" value="{{ old('token') }}" required
                                class="form-input" placeholder="Enter your unique token"
                                pattern="[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':&quot;\\|,.<>\/?~]{8,50}"
                                title="Token dapat berisi huruf, angka, dan karakter khusus" minlength="8"
                                maxlength="50">
                            <div class="validation-feedback" id="tokenFeedback"></div>
                            <small class="form-hint">Minimal 8 karakter, dapat mengandung karakter khusus</small>
                        </div>

                        <button type="submit" class="submit-btn" id="submitBtn">
                            Check Status
                        </button>

                        @if ($errors->any())
                            <div class="alert alert-error" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-error" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>

                <div class="sidebar-footer">
                    <p>© 2023 ArkaNatra. All rights reserved.</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container">
                <div class="content-header">
                    <h1 class="content-title">Work Order Details</h1>
                    <p class="content-subtitle">View the status and credentials for your work order</p>
                </div>

                @if (isset($workOrder))
                    <!-- Work Order Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Order Information</h2>
                        </div>
                        <div class="card-body">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <span class="detail-label">Reference ID</span>
                                    <span class="detail-value">{{ $workOrder->ref_id }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Customer</span>
                                    <span class="detail-value">{{ $workOrder->customer->name }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Status</span>
                                    <span
                                        class="status-badge {{ $workOrder->status }}">{{ ucfirst($workOrder->status) }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Queue Number</span>
                                    <span class="detail-value">#{{ $workOrder->antrian_ke ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Estimated Complete</span>
                                    <span class="detail-value">{{ $workOrder->estimasi_date }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Work Type</span>
                                    <span class="detail-value">{{ $workOrder->workType->work_type }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Access Credentials Section -->
                    @if (isset($workOrder->filteredAccessCredential))
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Access Credentials</h2>
                            </div>
                            <div class="card-body">
                                <div class="credentials-grid">
                                    @if ($workOrder->filteredAccessCredential->web)
                                        <div class="credential-card">
                                            <div class="credential-header">
                                                <div class="credential-icon website">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M12 20h9" />
                                                        <path
                                                            d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="credential-title">Website Access</h3>
                                                    <p class="credential-description">Control panel website credentials
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="credential-body">
                                                <div class="credential-field">
                                                    <label class="credential-label">URL</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->access_web }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->access_web }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Username</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->username_web }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->username_web }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Password</label>
                                                    <div class="credential-input-group">
                                                        <input type="password"
                                                            value="{{ $workOrder->filteredAccessCredential->password_web }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->password_web }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($workOrder->filteredAccessCredential->ojs)
                                        <div class="credential-card">
                                            <div class="credential-header">
                                                <div class="credential-icon ojs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="credential-title">OJS Access</h3>
                                                    <p class="credential-description">Open Journal System credentials
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="credential-body">
                                                <div class="credential-field">
                                                    <label class="credential-label">URL</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->akses_ojs }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->akses_ojs }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Username</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->username_ojs }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->username_ojs }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Password</label>
                                                    <div class="credential-input-group">
                                                        <input type="password"
                                                            value="{{ $workOrder->filteredAccessCredential->password_ojs }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->password_ojs }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- CPANEL Credential --}}
                                    @if ($workOrder->filteredAccessCredential->cpanel)
                                        <div class="credential-card">
                                            <div class="credential-header">
                                                <div class="credential-icon cpanel">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                                        <polyline points="7.5 4.21 12 6.81 16.5 4.21" />
                                                        <polyline points="7.5 19.79 7.5 14.6 3 12" />
                                                        <polyline points="21 12 16.5 14.6 16.5 19.79" />
                                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                                        <line x1="12" y1="22.08" x2="12"
                                                            y2="12" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="credential-title">cPanel Access</h3>
                                                    <p class="credential-description">Hosting control panel credentials
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="credential-body">
                                                <div class="credential-field">
                                                    <label class="credential-label">URL</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->akses_cpanel }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->akses_cpanel }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Username</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->username_cpanel }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->username_cpanel }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Password</label>
                                                    <div class="credential-input-group">
                                                        <input type="password"
                                                            value="{{ $workOrder->filteredAccessCredential->password_cpanel }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->password_cpanel }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- WEBMAIL Credential --}}
                                    @if ($workOrder->filteredAccessCredential->webmail)
                                        <div class="credential-card">
                                            <div class="credential-header">
                                                <div class="credential-icon webmail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <rect width="20" height="16" x="2" y="4"
                                                            rx="2" />
                                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="credential-title">Webmail Access</h3>
                                                    <p class="credential-description">Email web client credentials</p>
                                                </div>
                                            </div>
                                            <div class="credential-body">
                                                <div class="credential-field">
                                                    <label class="credential-label">URL</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->akses_webmail }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->akses_webmail }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Email</label>
                                                    <div class="credential-input-group">
                                                        <input type="text"
                                                            value="{{ $workOrder->filteredAccessCredential->username_webmail }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->username_webmail }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="credential-field">
                                                    <label class="credential-label">Password</label>
                                                    <div class="credential-input-group">
                                                        <input type="password"
                                                            value="{{ $workOrder->filteredAccessCredential->password_webmail }}"
                                                            class="credential-input" readonly>
                                                        <button type="button" class="copy-btn"
                                                            data-text="{{ $workOrder->filteredAccessCredential->password_webmail }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <rect width="14" height="14" x="8" y="8"
                                                                    rx="2" ry="2" />
                                                                <path
                                                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                            </svg>
                                                            Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <!-- Add similar blocks for cpanel and webmail if needed -->
                                </div>

                                <!-- Security Notice -->
                                <div class="security-notice">
                                    <div class="security-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                            <path d="M12 9v4" />
                                            <path d="M12 17h.01" />
                                        </svg>
                                    </div>
                                    <div class="security-content">
                                        <h4>Security Notice</h4>
                                        <p>Keep your credentials secure and do not share them with unauthorized parties.
                                            These credentials provide access to your systems and data.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- STATUS: VALIDATE --}}
                        @if ($workOrder->status === 'validate')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-blue-500 mb-3" xmlns="http://www.w3.org/2000/svg"
                                            width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                                            <path d="M2 17l10 5 10-5" />
                                            <path d="M2 12l10 5 10-5" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: Validate</h3>
                                        <p class="empty-description text-gray-600">
                                            Data Anda sedang dalam proses peninjauan oleh tim. Mohon menunggu proses
                                            verifikasi.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS: QUEUE --}}
                        @elseif ($workOrder->status === 'queue')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-amber-500 mb-3" xmlns="http://www.w3.org/2000/svg"
                                            width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 6v6l4 2" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: Queue</h3>
                                        <p class="empty-description text-gray-600">
                                            Data Anda telah masuk ke dalam antrean pengerjaan. Silakan cek secara
                                            berkala.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS: PENDING --}}
                        @elseif ($workOrder->status === 'pending')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-gray-500 mb-3" xmlns="http://www.w3.org/2000/svg"
                                            width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 8v4" />
                                            <circle cx="12" cy="16" r="1" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: Pending</h3>
                                        <p class="empty-description text-gray-600">
                                            Data Anda sedang dalam tahap tinjauan lanjutan oleh tim.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS: PROGRESS --}}
                        @elseif ($workOrder->status === 'progress')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-blue-600 animate-spin mb-3"
                                            xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 12a9 9 0 1 1-6-8.54" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: In Progress</h3>
                                        <p class="empty-description text-gray-600">
                                            Pekerjaan Anda sedang diproses oleh tim. Mohon menunggu hingga pekerjaan
                                            selesai.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS: REVISION --}}
                        @elseif ($workOrder->status === 'revision')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-purple-500 mb-3"
                                            xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 3v18h18" />
                                            <path d="M7 9l4 4 9-9" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: Revision</h3>
                                        <p class="empty-description text-gray-600">
                                            Pekerjaan Anda sedang direvisi berdasarkan kebutuhan atau permintaan
                                            tertentu.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS: MIGRATION --}}
                        @elseif ($workOrder->status === 'migration')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-teal-600 mb-3" xmlns="http://www.w3.org/2000/svg"
                                            width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M3 6h18" />
                                            <path d="M3 12h18" />
                                            <path d="M3 18h18" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: Migration</h3>
                                        <p class="empty-description text-gray-600">
                                            Pekerjaan Anda sedang menunggu proses migrasi, termasuk penyesuaian hosting
                                            dan domain.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS: FINISH --}}
                        @elseif ($workOrder->status === 'finish')
                            <div class="card">
                                <div class="card-body">
                                    <div class="empty-state text-center">
                                        <svg class="empty-icon text-green-600 mb-3" xmlns="http://www.w3.org/2000/svg"
                                            width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>

                                        <h3 class="empty-title text-xl font-semibold">Status: Finished</h3>
                                        <p class="empty-description text-gray-600">
                                            Pekerjaan Anda telah selesai. Terima kasih telah menggunakan layanan kami.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endif
                @else
                    <!-- Default State -->
                    <div class="card">
                        <div class="card-body">
                            <div class="empty-state">
                                <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                    <path d="M8 13h.01" />
                                    <path d="M16 13h.01" />
                                    <path d="M10 16a3.5 3.5 0 1 0 4 0" />
                                </svg>
                                <h3 class="empty-title">No Work Order Selected</h3>
                                <p class="empty-description">Enter your Reference ID and token in the sidebar to view
                                    your work order details.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/index.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy to clipboard functionality
            const copyButtons = document.querySelectorAll('.copy-btn');

            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const textToCopy = this.getAttribute('data-text');
                    const originalText = this.innerHTML;

                    // Copy to clipboard
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        // Visual feedback
                        this.innerHTML =
                            '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied!';
                        this.classList.add('copied');

                        // Revert after 2 seconds
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.classList.remove('copied');
                        }, 2000);
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                        this.innerHTML =
                            '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg> Error';

                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 2000);
                    });
                });
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }, 5000);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('queueForm');
            const refIdInput = document.getElementById('ref_id');
            const tokenInput = document.getElementById('token');
            const refIdFeedback = document.getElementById('refIdFeedback');
            const tokenFeedback = document.getElementById('tokenFeedback');
            const submitBtn = document.getElementById('submitBtn');

            // Pola regex untuk validasi client-side
            const refIdPattern = /^WO-\d{8}-[A-Za-z0-9]{6}$/;
            const tokenPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]{8,50}$/;

            function showFeedback(element, message, isValid) {
                element.textContent = message;
                element.style.color = isValid ? 'green' : 'red';
                element.style.fontSize = '0.875rem';
                element.style.marginTop = '0.25rem';
            }

            function clearFeedback(element) {
                element.textContent = '';
            }

            function validateRefId(refId) {
                if (refId.length > 20) {
                    return 'Reference ID maksimal 20 karakter';
                }
                if (!refIdPattern.test(refId)) {
                    return 'Format harus: AB-YYYYMMDD-XXXXXX';
                }

                // Validasi tanggal
                const parts = refId.split('-');
                if (parts.length === 3) {
                    const dateStr = parts[1];
                    if (dateStr.length === 8) {
                        const year = dateStr.substring(0, 4);
                        const month = dateStr.substring(4, 6);
                        const day = dateStr.substring(6, 8);

                        const date = new Date(year, month - 1, day);
                        if (date.getFullYear() != year || date.getMonth() != month - 1 || date.getDate() != day) {
                            return 'Tanggal dalam Reference ID tidak valid';
                        }
                    }
                }

                return null;
            }

            function validateToken(token) {
                if (token.length < 8) {
                    return 'Token minimal 8 karakter';
                }
                if (token.length > 50) {
                    return 'Token maksimal 50 karakter';
                }
                if (!tokenPattern.test(token)) {
                    return 'Token mengandung karakter yang tidak diizinkan';
                }

                // Validasi karakter berbahaya
                const dangerousChars = ["'", '"', ';', '--', '/*', '*/'];
                for (let char of dangerousChars) {
                    if (token.includes(char)) {
                        return 'Token mengandung karakter yang berbahaya';
                    }
                }

                return null;
            }

            // Real-time validation untuk ref_id
            refIdInput.addEventListener('input', function() {
                const error = validateRefId(this.value);
                if (error) {
                    showFeedback(refIdFeedback, error, false);
                    this.style.borderColor = 'red';
                } else {
                    showFeedback(refIdFeedback, 'Format valid', true);
                    this.style.borderColor = 'green';
                }
            });

            // Real-time validation untuk token
            tokenInput.addEventListener('input', function() {
                const error = validateToken(this.value);
                if (error) {
                    showFeedback(tokenFeedback, error, false);
                    this.style.borderColor = 'red';
                } else {
                    showFeedback(tokenFeedback, 'Format valid', true);
                    this.style.borderColor = 'green';
                }
            });

            // Validasi sebelum submit
            form.addEventListener('submit', function(e) {
                const refIdError = validateRefId(refIdInput.value);
                const tokenError = validateToken(tokenInput.value);

                if (refIdError || tokenError) {
                    e.preventDefault();

                    if (refIdError) {
                        showFeedback(refIdFeedback, refIdError, false);
                        refIdInput.style.borderColor = 'red';
                    }
                    if (tokenError) {
                        showFeedback(tokenFeedback, tokenError, false);
                        tokenInput.style.borderColor = 'red';
                    }

                    // Scroll ke error pertama
                    const firstError = refIdError ? refIdInput : tokenInput;
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            });

            // Clear feedback saat focus
            refIdInput.addEventListener('focus', function() {
                clearFeedback(refIdFeedback);
                this.style.borderColor = '';
            });

            tokenInput.addEventListener('focus', function() {
                clearFeedback(tokenFeedback);
                this.style.borderColor = '';
            });

            // Contoh input untuk testing
            function fillExample() {
                refIdInput.value = 'WO-20251124-O7CGiK';
                tokenInput.value = '=@n,-nLVh@';
                refIdInput.dispatchEvent(new Event('input'));
                tokenInput.dispatchEvent(new Event('input'));
            }
        });
    </script>
</body>

</html>
