<?php

namespace App\Http\Controllers;

use App\Models\AcademicTerm;
use App\Models\FeeStructure;
use App\Models\Program;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ManualEnrollmentController extends Controller
{
    public function index()
    {
        return view('enrollments.manual.index');
    }

    public function create()
    {
        $programs = Program::where('status', 'active')->get();
        $academicTerms = AcademicTerm::orderBy('start_date', 'desc')->get();
        return view('enrollments.manual.create', compact('programs', 'academicTerms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'program_id' => 'required|exists:programs,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:255',
            'national_id' => ['required', 'string', Rule::unique('students')],
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'admission_date' => 'required|date',
            'expected_graduation' => 'nullable|date|after:admission_date',
            'medical_notes' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'document_types' => 'nullable|array',
            'document_types.*' => 'nullable|string|in:id_card,birth_certificate,transcripts,passport,other',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $studentData = $validated;
            unset($studentData['email'], $studentData['password'], $studentData['documents'], $studentData['document_types']);
            $studentData['user_id'] = $user->id;
            $studentData['status'] = 'active';

            $student = Student::create($studentData);

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $index => $file) {
                    if ($file) {
                        $documentType = $validated['document_types'][$index] ?? 'other';
                        $path = $file->store('student_documents/' . $student->id, 'public');
                        
                        $student->documents()->create([
                            'document_type' => $documentType,
                            'original_filename' => $file->getClientOriginalName(),
                            'stored_filename' => basename($path),
                            'path' => $path,
                            'size_kb' => round($file->getSize() / 1024, 2),
                            'mime_type' => $file->getMimeType(),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('enrollments.manual.index')
            ->with('success', 'Student enrolled successfully!');
    }

    public function csvUpload()
    {
        return view('enrollments.csv.upload');
    }

    public function csvPreview(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $csv = array_map('str_getcsv', file($path));
        $headers = array_shift($csv);

        $requiredHeaders = [
            'student_id', 'first_name', 'last_name', 'date_of_birth', 'gender',
            'nationality', 'national_id', 'address', 'city', 'country', 'phone',
            'emergency_contact_name', 'emergency_contact_phone', 'program_id',
            'admission_date', 'email', 'password'
        ];

        $missingHeaders = array_diff($requiredHeaders, $headers);
        if (!empty($missingHeaders)) {
            return back()->withErrors(['csv_file' => 'Missing required columns: ' . implode(', ', $missingHeaders)]);
        }

        $preview = [];
        $errors = [];
        $programs = Program::pluck('id')->toArray();

        foreach (array_slice($csv, 0, 5) as $index => $row) {
            $rowData = array_combine($headers, $row);
            $rowErrors = [];

            if (!in_array($rowData['program_id'], $programs)) {
                $rowErrors[] = 'Invalid program_id';
            }

            if (!filter_var($rowData['email'], FILTER_VALIDATE_EMAIL)) {
                $rowErrors[] = 'Invalid email format';
            }

            if (User::where('email', $rowData['email'])->exists()) {
                $rowErrors[] = 'Email already exists';
            }

            if (Student::where('student_id', $rowData['student_id'])->exists()) {
                $rowErrors[] = 'Student ID already exists';
            }

            $preview[] = [
                'row' => $index + 2,
                'data' => $rowData,
                'errors' => $rowErrors
            ];
        }

        session(['csv_data' => $csv, 'csv_headers' => $headers]);

        return view('enrollments.csv.preview', compact('preview', 'headers'));
    }

    public function csvImport(Request $request)
    {
        if (!session('csv_data') || !session('csv_headers')) {
            return redirect()->route('enrollments.csv.upload')
                ->with('error', 'CSV session data expired. Please upload the file again.');
        }

        $csv = session('csv_data');
        $headers = session('csv_headers');

        $imported = 0;
        $failed = 0;
        $failures = [];

        DB::transaction(function () use ($csv, $headers, &$imported, &$failed, &$failures) {
            foreach ($csv as $index => $row) {
                $rowData = array_combine($headers, $row);
                $rowNumber = $index + 2;

                try {
                    $user = User::create([
                        'name' => $rowData['first_name'] . ' ' . $rowData['last_name'],
                        'email' => $rowData['email'],
                        'password' => Hash::make($rowData['password']),
                    ]);

                    Student::create([
                        'user_id' => $user->id,
                        'student_id' => $rowData['student_id'],
                        'program_id' => $rowData['program_id'],
                        'first_name' => $rowData['first_name'],
                        'last_name' => $rowData['last_name'],
                        'date_of_birth' => $rowData['date_of_birth'],
                        'gender' => $rowData['gender'],
                        'nationality' => $rowData['nationality'],
                        'national_id' => $rowData['national_id'],
                        'address' => $rowData['address'],
                        'city' => $rowData['city'],
                        'state' => $rowData['state'] ?? null,
                        'postal_code' => $rowData['postal_code'] ?? null,
                        'country' => $rowData['country'],
                        'phone' => $rowData['phone'],
                        'emergency_contact_name' => $rowData['emergency_contact_name'],
                        'emergency_contact_phone' => $rowData['emergency_contact_phone'],
                        'admission_date' => $rowData['admission_date'],
                        'expected_graduation' => $rowData['expected_graduation'] ?? null,
                        'medical_notes' => $rowData['medical_notes'] ?? null,
                        'status' => 'active',
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $failed++;
                    $failures[] = [
                        'row' => $rowNumber,
                        'student_id' => $rowData['student_id'] ?? 'N/A',
                        'error' => $e->getMessage()
                    ];
                }
            }
        });

        session()->forget(['csv_data', 'csv_headers']);

        return view('enrollments.csv.result', compact('imported', 'failed', 'failures'));
    }
}
