<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Intake;
use App\Models\AuditLog;
use App\Models\ClinicalNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        // Initialize safe empty collections
        $trackedPatients = collect();
        $intakes = collect();
        $auditLogs = collect();
        $incompleteDocs = collect();

        // Initialize baseline metrics
        $activeCaseloadCount = 0;
        $highRiskCount = 0;
        $pendingFollowUps = 0;
        $complianceRate = '100%';

        // ==========================================
        // ROLE-BASED DATA ISOLATION (ZERO CROSS-TALK)
        // ==========================================

        if ($user->hasAnyRole(['clinician', 'care-coordinator'])) {
            
            // 1. Calculate clinical-scoped aggregate metrics
            $activeCaseloadCount = Patient::where('status', 'active')->count();
            $highRiskCount = Patient::where('risk_level', 'High')->count();
            $pendingFollowUps = Patient::where('follow_up_due', '<=', now()->endOfDay())
                ->where('status', 'active')
                ->count();

            $totalNotes = ClinicalNote::count();
            $incompleteNotesCount = ClinicalNote::where('is_complete', false)->count();
            $complianceRate = $totalNotes > 0 
                ? round((($totalNotes - $incompleteNotesCount) / $totalNotes) * 100, 1) . '%' 
                : '100%';

            // 2. Fetch QA Sidebar data ONLY for medical personnel
            $incompleteDocs = ClinicalNote::with('patient')
                ->where('is_complete', false)
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($note) {
                    return (object) [
                        'note_id' => $note->id,
                        'patient_name' => $note->patient->name ?? 'Anonymous Student',
                        'missing_element' => $note->missing_field_label ?? 'Clinical Signature',
                    ];
                });

            // 3. Populate specific workspace rows based on individual clinical taskings
            if ($user->hasRole('clinician')) {
                $query = Patient::where('risk_level', 'High')
                    ->where('assigned_clinician_id', $user->id);

                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('student_id', 'LIKE', "%{$search}%");
                    });
                }

                $trackedPatients = $query->latest('updated_at')->take(10)->get();
            }

            if ($user->hasRole('care-coordinator')) {
                $query = Intake::with('clinician')
                    ->whereIn('stage', ['Pending Review', 'Awaiting Matching']);

                if ($search) {
                    $query->whereHas('patient', function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
                }

                $intakes = $query->orderBy('action_due_at', 'asc')->take(10)->get();
            }

        } elseif ($user->hasRole('admin')) {
            // System administrators ONLY pull system trails.
            // Absolute separation from the clinical tables.
            $query = AuditLog::with('user');

            if ($search) {
                $query->where('action', 'LIKE', "%{$search}%")
                      ->orWhere('ip_address', 'LIKE', "%{$search}%");
            }

            $auditLogs = $query->latest()->take(15)->get();
        }

        return view('dashboard', compact(
            'activeCaseloadCount',
            'highRiskCount',
            'complianceRate',
            'pendingFollowUps',
            'incompleteDocs',
            'trackedPatients',
            'intakes',
            'auditLogs',
            'search'
        ));
    }
}