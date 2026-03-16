<?php

namespace App\Services;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateService
{
    public function generateCertificate(Certificate $certificate): Certificate
    {
        // Certificate generation logic is handled in OnlineExamService
        return $certificate;
    }

    public function downloadCertificate(Certificate $certificate): RedirectResponse
    {
        // Generate PDF certificate (simplified version)
        $pdfContent = $this->generateCertificatePDF($certificate);
        
        $filename = 'certificate_' . $certificate->certificate_number . '.pdf';
        
        // Store PDF temporarily
        Storage::put('certificates/' . $filename, $pdfContent);
        
        // Update certificate URL
        $certificate->update([
            'certificate_url' => Storage::url('certificates/' . $filename),
        ]);

        return Storage::download('certificates/' . $filename, $filename);
    }

    protected function generateCertificatePDF(Certificate $certificate): string
    {
        // Simple HTML to PDF conversion (you can enhance this with proper PDF library)
        $html = '
        <div style="font-family: Arial, sans-serif; padding: 20px; border: 2px solid #ddd; width: 600px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #2c3e50; margin-bottom: 10px;">Certificate of Completion</h1>
                <h2 style="color: #4a5568; font-size: 24px; margin-bottom: 20px;">' . htmlspecialchars($certificate->title) . '</h2>
            </div>
            
            <div style="margin-bottom: 30px;">
                <p><strong>Student:</strong> ' . htmlspecialchars($certificate->student->name) . '</p>
                <p><strong>Course:</strong> ' . htmlspecialchars($certificate->course?->name ?? 'N/A') . '</p>
                <p><strong>Score:</strong> ' . $certificate->getFormattedScore() . '</p>
                <p><strong>Percentage:</strong> ' . $certificate->getFormattedPercentage() . '</p>
                <p><strong>Issue Date:</strong> ' . $certificate->issue_date->format('F j, Y') . '</p>
                <p><strong>Expiry Date:</strong> ' . ($certificate->expiry_date ? $certificate->expiry_date->format('F j, Y') : 'Never') . '</p>
            </div>
            
            <div style="margin-top: 40px; text-align: center;">
                <p style="font-size: 12px; color: #666;">
                    Verification Code: <strong>' . htmlspecialchars($certificate->verification_code) . '</strong>
                </p>
                <p style="font-size: 10px; color: #999; margin-top: 10px;">
                    Verify this certificate at: ' . route('certificates.verify', $certificate->verification_code) . '
                </p>
            </div>
        </div>
        ';

        // Convert HTML to PDF (basic implementation)
        return $html;
    }

    public function verifyCertificate(string $verificationCode): ?Certificate
    {
        return Certificate::where('verification_code', $verificationCode)
            ->where('status', 'active')
            ->first();
    }

    public function getStudentCertificates(int $studentId): array
    {
        return Certificate::with(['exam', 'course'])
            ->where('student_id', $studentId)
            ->orderBy('issue_date', 'desc')
            ->get();
    }

    public function revokeCertificate(Certificate $certificate): void
    {
        $certificate->update(['status' => 'revoked']);
    }

    public function getCertificateStatistics(): array
    {
        $totalCertificates = Certificate::count();
        $activeCertificates = Certificate::where('status', 'active')->count();
        $expiredCertificates = Certificate::where('status', 'expired')->count();
        $revokedCertificates = Certificate::where('status', 'revoked')->count();
        
        return [
            'total_certificates' => $totalCertificates,
            'active_certificates' => $activeCertificates,
            'expired_certificates' => $expiredCertificates,
            'revoked_certificates' => $revokedCertificates,
        ];
    }
}
