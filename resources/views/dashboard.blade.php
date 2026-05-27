Here is the fully updated, modernized version of your dashboard. The structure, Blade directives, and logic remain completely intact, but the raw CSS has been overhauled to use a crisp, modern aesthetic: a deep emerald palette, refined typography scales, subtle transitions, and flexible layouts.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKalinga — Clinical Dashboard</title>

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    {{-- Vite (Laravel asset bundler) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Modern Design System Variables ── */
        :root {
            --bg-main: #f8fafc;
            --surface-card: #ffffff;
            --border-color: #f1f5f9;
            --border-color-hover: #e2e8f0;
            
            /* Typography Colors */
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;

            /* Brand Accent - Premium Deep Emerald */
            --primary: #0d523c;
            --primary-hover: #083b2b;
            --primary-light: #f0fdf4;
            --primary-text: #166534;

            /* Semantic Colors */
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --danger-text: #991b1b;

            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --warning-text: #92400e;

            --success: #10b981;
            --success-light: #ecfdf5;
            --success-text: #065f46;

            /* Shadows & Border Radii */
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-subtle: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
            --transition-smooth: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-main);
            color: var(--text-body);
            min-height: 100vh;
            padding: 2.5rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .dashboard-container {
            max-width: 1440px;
            margin: 0 auto;
        }

        /* ── Header Styling ── */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .brand-meta h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-heading);
            letter-spacing: -0.75px;
        }

        .brand-meta p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-badge {
            background-color: var(--primary-light);
            color: var(--primary-text);
            padding: 4px 10px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(22, 101, 52, 0.1);
        }

        /* ── Action Buttons ── */
        .action-group {
            display: flex;
            gap: 12px;
        }

        .btn-ekalinga {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            font-size: 13.5px;
            font-weight: 600;
            border-radius: var(--radius-md);
            border: 1px solid transparent;
            background: var(--primary);
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-smooth);
            box-shadow: var(--shadow-subtle);
        }

        .btn-ekalinga:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: var(--surface-card);
            color: var(--text-body);
            border: 1px solid var(--border-color-hover);
        }

        .btn-outline:hover {
            background: var(--bg-main);
            color: var(--text-heading);
            border-color: #cbd5e1;
        }

        /* ── Content Layout ── */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2.2fr 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        @media (max-width: 1150px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Summary Metrics ── */
        .metrics-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1rem;
            grid-column: 1 / -1;
        }

        .metric-card {
            background: var(--surface-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.02), 0 4px 6px -4px rgba(0, 0, 0, 0.02);
        }

        /* Colored top border accent instead of heavy left block borders */
        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #94a3b8;
        }

        .metric-card.primary::before { background-color: var(--primary); }
        .metric-card.danger::before { background-color: var(--danger); }
        .metric-card.warning::before { background-color: var(--warning); }
        .metric-card.success::before { background-color: var(--success); }

        .metric-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .metric-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-heading);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .metric-value i {
            font-size: 24px;
            padding: 8px;
            border-radius: var(--radius-md);
            background: var(--bg-main);
        }

        .metric-card.primary i { background: var(--primary-light); color: var(--primary); }
        .metric-card.danger i { background: var(--danger-light); color: var(--danger); }
        .metric-card.warning i { background: var(--warning-light); color: var(--warning); }
        .metric-card.success i { background: var(--success-light); color: var(--success); }

        /* ── Cards & Panels ── */
        .ekalinga-card {
            background: var(--surface-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .card-header-panel {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }

        .card-title-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-heading);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title-text i {
            font-size: 20px;
            color: var(--primary);
        }

        .card-title-text.danger i { color: var(--danger); }

        .panel-badge {
            font-size: 11px;
            background: var(--primary-light);
            color: var(--primary-text);
            padding: 4px 10px;
            border-radius: 9999px;
            font-weight: 600;
        }

        .panel-badge.danger {
            background: var(--danger-light);
            color: var(--danger-text);
        }

        /* ── Clean Micro Tables ── */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .ekalinga-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13.5px;
        }

        .ekalinga-table th {
            background: #fafafa;
            padding: 14px 24px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
        }

        .ekalinga-table td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-body);
            vertical-align: middle;
        }

        .ekalinga-table tr:hover td {
            background-color: #fafbfb;
        }

        .ekalinga-table tr:last-child td {
            border-bottom: none;
        }

        .ekalinga-table code {
            background: var(--bg-main);
            padding: 3px 6px;
            border-radius: 6px;
            font-size: 12px;
            border: 1px solid var(--border-color-hover);
        }

        /* Modern Status Pills */
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .status-pill.high { background: var(--danger-light); color: var(--danger-text); }
        .status-pill.medium { background: var(--warning-light); color: var(--warning-text); }
        .status-pill.low { background: var(--bg-main); color: var(--text-body); }

        /* Document List Widget */
        .doc-list {
            list-style: none;
            padding: 0 24px 16px;
        }

        .doc-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .doc-item:last-child { border-bottom: none; }

        .doc-info .doc-name { font-weight: 600; color: var(--text-heading); }
        .doc-info .doc-meta { 
            font-size: 12px; 
            color: var(--danger-text); 
            margin-top: 4px; 
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Security Banner ── */
        .security-banner {
            background: var(--surface-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .security-banner i {
            color: var(--primary);
            font-size: 22px;
            background: var(--primary-light);
            padding: 10px;
            border-radius: var(--radius-md);
        }

        .security-banner p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── Micro Animations ── */
        .pulse-icon {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse-ring {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .6; transform: scale(1.05); }
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    {{-- ── TOP HEADER SECTION ── --}}
    <header class="dashboard-header">
        <div class="brand-meta">
            <h1>Clinical Oversight Portal</h1>
            <p>
                Logged in as <strong>{{ auth()->user()->name }}</strong> 
                <span class="role-badge">{{ auth()->user()->role ?? 'Clinician' }}</span>
            </p>
        </div>

        <div class="action-group">
            <button class="btn-ekalinga" onclick="window.location.href='#intake'">
                <i class="ti ti-square-plus"></i> New Intake
            </button>
            <button class="btn-ekalinga btn-outline" onclick="window.location.href='#notes'">
                <i class="ti ti-file-text"></i> Quick Note
            </button>
            @can('manage-billing')
            <button class="btn-ekalinga btn-outline" onclick="window.location.href='#billing'">
                <i class="ti ti-credit-card"></i> Process Billing
            </button>
            @endcan
        </div>
    </header>

    {{-- ── MAIN LAYOUT GRID ── --}}
    <div class="dashboard-grid">
        
        {{-- METRICS ROW --}}
        <div class="metrics-row">
            {{-- Real-time Caseload --}}
            @hasanyrole('clinician|care-coordinator')
            <div class="metric-card primary">
                <p class="metric-label">Active Caseload</p>
                <div class="metric-value">
                    <i class="ti ti-users"></i>
                    {{ $activeCaseloadCount ?? 42 }} Students
                </div>
            </div>
            @endhasanyrole

            {{-- Clinical Oversight Risk Signals --}}
            @hasanyrole('clinician|admin')
            <div class="metric-card danger">
                <p class="metric-label">High-Risk Signals</p>
                <div class="metric-value">
                    <i class="ti ti-alert-triangle pulse-icon"></i>
                    {{ $highRiskCount ?? 3 }} Urgent Flags
                </div>
            </div>
            @endhasanyrole

            {{-- Compliance metric --}}
            <div class="metric-card warning">
                <p class="metric-label">Documentation Completeness</p>
                <div class="metric-value">
                    <i class="ti ti-shield-check"></i>
                    {{ $complianceRate ?? '96.4%' }}
                </div>
            </div>

            {{-- Workflow Pending follow-ups --}}
            <div class="metric-card success">
                <p class="metric-label">Follow-ups Due Today</p>
                <div class="metric-value">
                    <i class="ti ti-clock"></i>
                    {{ $pendingFollowUps ?? 5 }} Tasks
                </div>
            </div>
        </div>

        {{-- LEFT MAIN PANEL: Dynamic Role-Based Data Views --}}
        <main class="main-content-column">
            
            {{-- VIEW: CLINICIAN --}}
            @hasrole('clinician')
            <div class="ekalinga-card">
                <div class="card-header-panel">
                    <div class="card-title-text danger">
                        <i class="ti ti-heartbeat"></i> Real-Time Caseload & Risk Signals
                    </div>
                    <span class="panel-badge danger">Live updates</span>
                </div>
                <div class="table-responsive">
                    <table class="ekalinga-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Risk Level</th>
                                <th>Trigger Signal</th>
                                <th>Last Activity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trackedPatients as $patient)
                            <tr>
                                <td><strong>{{ $patient->name }}</strong><br><small style="color:var(--text-muted);">{{ $patient->student_id }}</small></td>
                                <td><span class="status-pill {{ $patient->risk_class }}">{{ $patient->risk_level }}</span></td>
                                <td>{{ $patient->latest_signal }}</td>
                                <td>{{ $patient->updated_at->diffForHumans() }}</td>
                                <td><a href="{{ route('patients.show', $patient->id) }}" class="btn-ekalinga btn-outline" style="padding: 6px 12px; font-size:12px;">Review</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">No active high-risk indicators found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endhasrole

            {{-- VIEW: CARE COORDINATOR --}}
            @hasrole('care-coordinator')
            <div class="ekalinga-card">
                <div class="card-header-panel">
                    <div class="card-title-text">
                        <i class="ti ti-git-pull-request"></i> Active Student Intake Pipeline
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="ekalinga-table">
                        <thead>
                            <tr>
                                <th>Student Applicant</th>
                                <th>Workflow Stage</th>
                                <th>Assigned Specialist</th>
                                <th>Due In</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($intakes as $intake)
                            <tr>
                                <td><strong>{{ $intake->name }}</strong></td>
                                <td><span class="status-pill medium">{{ $intake->stage }}</span></td>
                                <td>{{ $intake->clinician->name ?? 'Unassigned' }}</td>
                                <td style="color:var(--danger); font-weight:600;">{{ $intake->action_due_at->diffForHumans() }}</td>
                                <td><a href="{{ route('intake.process', $intake->id) }}" class="btn-ekalinga" style="padding: 6px 12px; font-size:12px;">Process</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">No pending entry Intakes left to evaluate.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endhasrole

            {{-- VIEW: ADMIN --}}
            @hasrole('admin')
            <div class="ekalinga-card">
                <div class="card-header-panel">
                    <div class="card-title-text">
                        <i class="ti ti-history"></i> Privacy & Compliance Audit Trail
                    </div>
                    <a href="{{ route('audit.logs') }}" style="font-size:13px; color:var(--primary); text-decoration:none; font-weight:600;">View full logs</a>
                </div>
                <div class="table-responsive">
                    <table class="ekalinga-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Personnel</th>
                                <th>Action Performed</th>
                                <th>Resource ID</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auditLogs as $log)
                            <tr style="{{ $log->is_suspicious ? 'background: var(--danger-light);' : '' }}">
                                <td style="color:var(--text-muted); font-size:12px;">{{ $log->created_at }}</td>
                                <td><strong>{{ $log->user->name }}</strong> <span style="color: var(--text-muted); font-size: 12px;">({{ $log->user->role }})</span></td>
                                <td><span class="status-pill low">{{ $log->action }}</span></td>
                                <td><code>{{ $log->resource_type }} #{{ $log->resource_id }}</code></td>
                                <td style="font-family:monospace; color:var(--text-muted); font-size:12px;">{{ $log->ip_address }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">No logs systematically indexed during this lifecycle.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endhasrole

        </main>

        {{-- RIGHT COLUMN: Global Compliance Controls & Security Notices --}}
        <aside class="side-content-column">
            
            {{-- Documentation Quality Check Widget --}}
            <div class="ekalinga-card">
                <div class="card-header-panel">
                    <div class="card-title-text">
                        <i class="ti ti-checkbox" style="color:var(--warning);"></i> Documentation QA Check
                    </div>
                </div>
                <ul class="doc-list">
                    @forelse($incompleteDocs as $doc)
                    <li class="doc-item">
                        <div class="doc-info">
                            <div class="doc-name">{{ $doc->patient_name }}</div>
                            <div class="doc-meta"><i class="ti ti-circle-x"></i> Missing {{ $doc->missing_element }}</div>
                        </div>
                        <a href="{{ route('notes.edit', $doc->note_id) }}" class="btn-ekalinga btn-outline" style="padding:6px 12px; font-size:12px;" title="Sign documentation">Complete</a>
                    </li>
                    @empty
                    <li style="text-align:center; padding:24px 0; color:var(--text-muted); font-size:13px;">
                        <i class="ti ti-circle-check" style="color:var(--success); font-size:18px; vertical-align:middle; margin-right:4px;"></i> All records compliant.
                    </li>
                    @endforelse
                </ul>
            </div>

            {{-- Hardened Privacy Protection Notice Widget --}}
            <div class="security-banner">
                <i class="ti ti-shield-lock"></i>
                <div>
                    <p style="font-weight: 700; color: var(--text-heading); margin-bottom: 4px;">Data Encryption Active</p>
                    <p>
                        Authorized PLSP Center for Mental Health environment. All record sessions, access to Protected Health Information (PHI), and modifications are permanently logged for audit trails under regulatory privacy mandates.
                    </p>
                </div>
            </div>

        </aside>

    </div>
</div>

</body>
</html>

```