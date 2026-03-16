<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['program', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $programs = Program::where('status', 'active')->get();
        return view('applications.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:255',
            'national_id' => 'required|string|unique:applications,national_id',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:applications,email|unique:users,email',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'program_id' => 'required|exists:programs,id',
            'notes' => 'nullable|string',
            'documents' => 'required|array|min:1',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'document_types' => 'required|array|min:1',
            'document_types.*' => 'required|string|in:id_card,birth_certificate,transcripts,passport,other',
        ]);

        $application = Application::create($validated);

        foreach ($request->file('documents') as $index => $file) {
            $documentType = $validated['document_types'][$index];
            $storedFilename = $file->store('application_documents', 'public');
            
            ApplicationDocument::create([
                'application_id' => $application->id,
                'document_type' => $documentType,
                'original_filename' => $file->getClientOriginalName(),
                'stored_filename' => basename($storedFilename),
                'path' => $storedFilename,
                'size_kb' => round($file->getSize() / 1024, 2),
                'mime_type' => $file->getMimeType(),
            ]);
        }

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application submitted successfully! We will review it and contact you soon.');
    }

    public function show(Application $application)
    {
        $application->load(['program', 'documents', 'reviewer']);
        return view('applications.show', compact('application'));
    }

    public function approve(Application $application)
    {
        $this->authorize('manage', $application);

        DB::transaction(function () use ($application) {
            $user = User::create([
                'name' => $application->full_name,
                'email' => $application->email,
                'password' => Hash::make(strtoupper($application->national_id)),
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU-' . date('Y') . '-' . str_pad($application->id, 4, '0', STR_PAD_LEFT),
                'program_id' => $application->program_id,
                'first_name' => $application->first_name,
                'last_name' => $application->last_name,
                'date_of_birth' => $application->date_of_birth,
                'gender' => $application->gender,
                'nationality' => $application->nationality,
                'national_id' => $application->national_id,
                'address' => $application->address,
                'city' => $application->city,
                'state' => $application->state,
                'postal_code' => $application->postal_code,
                'country' => $application->country,
                'phone' => $application->phone,
                'emergency_contact_name' => $application->emergency_contact_name,
                'emergency_contact_phone' => $application->emergency_contact_phone,
                'admission_date' => now(),
                'status' => 'active',
            ]);

            $application->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        });

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application approved! Student account created successfully.');
    }

    public function reject(Request $request, Application $application)
    {
        $this->authorize('manage', $application);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application rejected.');
    }

    public function downloadDocument(ApplicationDocument $document)
    {
        $this->authorize('view', $document->application);

        return Storage::disk('public')->download($document->path, $document->original_filename);
    }
}
