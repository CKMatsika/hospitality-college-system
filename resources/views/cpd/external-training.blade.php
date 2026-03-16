@extends('layouts.qbo')

@section('title', 'External Training')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-external-link-alt mr-2"></i>
            Submit External Training
        </h1>
        <p class="text-gray-600 mt-2">Add external training activities and courses to your CPD record.</p>
    </div>
            </h1>
            <p class="text-gray-600 mt-2">Add external training activities for CPD points approval</p>
        </div>

        <!-- External Training Form -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('cpd.external-training.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="activity_name" class="block text-sm font-medium text-gray-700">
                                Activity Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="activity_name" name="activity_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g., Advanced Food Safety Certification">
                        </div>
                        
                        <div>
                            <label for="provider" class="block text-sm font-medium text-gray-700">
                                Training Provider <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="provider" name="provider" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g., National Restaurant Association">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Describe the training content, skills learned, and outcomes..."></textarea>
                    </div>

                    <!-- Category and Duration -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="cpd_category_id" class="block text-sm font-medium text-gray-700">
                                CPD Category <span class="text-red-500">*</span>
                            </label>
                            <select id="cpd_category_id" name="cpd_category_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="start_date" name="start_date" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="end_date" name="end_date" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Hours and Certificate -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="hours" class="block text-sm font-medium text-gray-700">
                                Training Hours <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="hours" name="hours" min="1" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Total hours of training">
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                1 CPD point per hour (maximum 10 points per activity)
                            </p>
                        </div>
                        
                        <div>
                            <label for="certificate_file" class="block text-sm font-medium text-gray-700">
                                Certificate File
                            </label>
                            <input type="file" id="certificate_file" name="certificate_file" 
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">
                                PDF, JPG, or PNG (Max 2MB)
                            </p>
                        </div>
                    </div>

                    <!-- Points Preview -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h3 class="text-sm font-medium text-blue-900 mb-2">
                            <i class="fas fa-calculator mr-2"></i>
                            Estimated CPD Points
                        </h3>
                        <div class="text-2xl font-bold text-blue-900" id="points-preview">
                            0 points
                        </div>
                        <p class="text-sm text-blue-700 mt-1">
                            Points will be calculated based on training hours (1 point per hour, max 10 points)
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit for Approval
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Guidelines -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-yellow-900 mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                Submission Guidelines
            </h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-yellow-600 mt-1 mr-3"></i>
                    <p class="text-sm text-yellow-800">
                        Training must be relevant to hospitality industry and professional development
                    </p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-yellow-600 mt-1 mr-3"></i>
                    <p class="text-sm text-yellow-800">
                        Certificate or proof of completion is required for approval
                    </p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-yellow-600 mt-1 mr-3"></i>
                    <p class="text-sm text-yellow-800">
                        Maximum 10 CPD points per external training activity
                    </p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-yellow-600 mt-1 mr-3"></i>
                    <p class="text-sm text-yellow-800">
                        All submissions are subject to admin approval before points are awarded
                    </p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-yellow-600 mt-1 mr-3"></i>
                    <p class="text-sm text-yellow-800">
                        Approved activities will be valid for 12 months from approval date
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Calculate points preview based on hours
document.getElementById('hours').addEventListener('input', function() {
    const hours = parseInt(this.value) || 0;
    const points = Math.min(hours, 10);
    document.getElementById('points-preview').textContent = points + ' points';
});

// Set minimum date for end date
document.getElementById('start_date').addEventListener('change', function() {
    document.getElementById('end_date').min = this.value;
});
</script>
@endsection
