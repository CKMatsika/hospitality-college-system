<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificateController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    // Student certificates list
    public function index(): View
    {
        $certificates = Certificate::with(['exam', 'course', 'student'])
            ->where('student_id', auth()->id())
            ->orderBy('issue_date', 'desc')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    // Show certificate details
    public function show(Certificate $certificate): View
    {
        $certificate->load(['exam', 'course', 'student']);
        
        $this->authorize('view', $certificate);

        return view('certificates.show', compact('certificate'));
    }

    // Verify certificate
    public function verify(Certificate $certificate): View
    {
        return view('certificates.verify', compact('certificate'));
    }

    // Download certificate
    public function download(Certificate $certificate): RedirectResponse
    {
        $this->authorize('view', $certificate);

        return $this->certificateService->downloadCertificate($certificate);
    }
}
