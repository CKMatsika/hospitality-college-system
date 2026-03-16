@extends('layouts.qbo')

@section('title', 'Application Details')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-file-alt mr-2"></i>
            Application Details
        </h1>
        <p class="text-gray-600 mt-2">View and manage application information.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            Application #{{ $application->application_number }}
                        </h3>
                        <div class="flex space-x-2">
                            @if ($application->status === 'pending')
                                <form action="{{ route('applications.approve', $application) }}" method="POST" class="inline" onsubmit="return confirm('Approve this application and create a student account?')">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                        Approve
                                    </button>
                                </form>
                                <button onclick="document.getElementById('reject-form').classList.toggle('hidden')" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    Reject
                                </button>
                            @endif
                            <a href="{{ route('applications.index') }}" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4 rounded-lg border border-gray-300">
                                Back to List
                            </a>
                        </div>
                    </div>

                    @if ($application->status === 'pending')
                        <form id="reject-form" action="{{ route('applications.reject', $application) }}" method="POST" class="hidden mb-6 p-4 bg-red-50 rounded-lg">
                            @csrf
                            <div class="mb-3">
                                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"></textarea>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    Confirm Rejection
                                </button>
                                <button type="button" onclick="document.getElementById('reject-form').classList.add('hidden')" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4 rounded-lg border border-gray-300">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-3">Personal Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Full Name</span>
                                    <span class="text-sm text-gray-900">{{ $application->full_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Date of Birth</span>
                                    <span class="text-sm text-gray-900">{{ $application->date_of_birth->format('M d, Y') }} ({{ $application->age }} years)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Gender</span>
                                    <span class="text-sm text-gray-900">{{ ucfirst($application->gender) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nationality</span>
                                    <span class="text-sm text-gray-900">{{ $application->nationality }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">National ID</span>
                                    <span class="text-sm text-gray-900">{{ $application->national_id }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-3">Contact Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Email</span>
                                    <span class="text-sm text-gray-900">{{ $application->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Phone</span>
                                    <span class="text-sm text-gray-900">{{ $application->phone }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Address</span>
                                    <span class="text-sm text-gray-900">{{ $application->address }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">City</span>
                                    <span class="text-sm text-gray-900">{{ $application->city }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Country</span>
                                    <span class="text-sm text-gray-900">{{ $application->country }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-3">Academic Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Program</span>
                                    <span class="text-sm text-gray-900">{{ $application->program->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Applied Date</span>
                                    <span class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-3">Application Status</h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Status</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $application->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                @if ($application->reviewed_at)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Reviewed At</span>
                                        <span class="text-sm text-gray-900">{{ $application->reviewed_at->format('M d, Y H:i') }}</span>
                                    </div>
                                @endif
                                @if ($application->reviewer)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Reviewed By</span>
                                        <span class="text-sm text-gray-900">{{ $application->reviewer->name }}</span>
                                    </div>
                                @endif
                                @if ($application->rejection_reason)
                                    <div>
                                        <span class="text-sm text-gray-600">Rejection Reason</span>
                                        <p class="text-sm text-red-600 mt-1">{{ $application->rejection_reason }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($application->notes)
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Additional Notes</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-900">{{ $application->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Uploaded Documents</h4>
                        @if ($application->documents->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Filename</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Uploaded</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($application->documents as $document)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $document->original_filename }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $document->formatted_size }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $document->created_at->format('M d, Y H:i') }}</td>
                                                <td class="px-4 py-2 text-sm">
                                                    <a href="{{ route('applications.download-document', $document) }}" 
                                                       class="text-blue-600 hover:text-blue-900" download>Download</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No documents uploaded.</p>
                        @endif
                    </div>

                    @if ($application->status === 'approved')
                        <div class="mt-6 p-4 bg-green-50 rounded-lg">
                            <h4 class="text-md font-medium text-green-800 mb-2">✅ Application Approved</h4>
                            <p class="text-sm text-green-700">
                                A student account has been created for this applicant. The student can now log in using their email and national ID as password.
                            </p>
                        </div>
                    @endif

                    @if ($application->status === 'rejected')
                        <div class="mt-6 p-4 bg-red-50 rounded-lg">
                            <h4 class="text-md font-medium text-red-800 mb-2">❌ Application Rejected</h4>
                            <p class="text-sm text-red-700">
                                This application has been rejected. The applicant will need to submit a new application if they wish to be considered.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
