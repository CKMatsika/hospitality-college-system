@extends('layouts.qbo')

@section('title', 'Online Exams')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-graduation-cap mr-2"></i>
            Online Exams
        </h1>
        <p class="text-gray-600 mt-2">Manage and monitor online examinations with proctoring features.</p>
    </div>

    <!-- Exam Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Exams" 
            value="24" 
            icon="fas fa-file-alt" 
            color="blue"
            trend="stable"
            trendValue="All exams"
        />
        <x-stat-card 
            title="Published" 
            value="18" 
            icon="fas fa-check-circle" 
            color="green"
            trend="up"
            trendValue="Available to students"
        />
        <x-stat-card 
            title="In Progress" 
            value="6" 
            icon="fas fa-clock" 
            color="yellow"
            trend="stable"
            trendValue="Currently active"
        />
        <x-stat-card 
            title="Completed" 
            value="142" 
            icon="fas fa-trophy" 
            color="purple"
            trend="up"
            trendValue="Total submissions"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('online-learning.exams.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Exam
            </a>
            <a href="#" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-chart-bar mr-2"></i> View Analytics
            </a>
            <a href="{{ route('online-learning.certificates.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-certificate mr-2"></i> Manage Certificates
            </a>
        </div>
    </div>

    <!-- Recent Exams -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Exams</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>

                <!-- Exams List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Course
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Start Time
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    End Time
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Duration
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Submissions
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($exams as $exam)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $exam->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $exam->course->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $exam->start_time->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $exam->end_time->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $exam->duration_minutes }} minutes
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $exam->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $exam->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $exam->submissions->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($exam->questions->count() > 0)
                                                <a href="{{ route('online-learning.exams.questions', $exam) }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-question-circle mr-1"></i>
                                                    Questions
                                                </a>
                                            @endif
                                            
                                            @if($exam->is_published)
                                                <a href="{{ route('online-learning.exams.take', $exam) }}" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-play mr-1"></i>
                                                    Take Exam
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('online-learning.exams.show', $exam) }}" class="text-gray-600 hover:text-gray-900">
                                                <i class="fas fa-eye mr-1"></i>
                                                View
                                            </a>
                                            
                                            @if($exam->submissions->count() > 0)
                                                <a href="{{ route('online-learning.exams.results', $exam->submissions->first()) }}" class="text-purple-600 hover:text-purple-900">
                                                    <i class="fas fa-chart-bar mr-1"></i>
                                                    Results
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($exams->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No exams found</p>
                        <p class="text-gray-400 text-sm mt-2">Get started by creating your first online exam</p>
                        <div class="mt-4">
                            <a href="{{ route('online-learning.exams.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Create Your First Exam
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
