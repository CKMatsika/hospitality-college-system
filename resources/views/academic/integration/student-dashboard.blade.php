@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-chart-line mr-3"></i>
                Academic Integration Dashboard
            </h1>
            <p class="text-gray-600 mt-2">Complete view of your academic progress across all learning systems</p>
        </div>

        <!-- Key Metrics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Overall GPA</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($academicProgress['overall_gpa'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Credits</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $academicProgress['total_credits'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Certificates</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $academicProgress['certifications']->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-chart-bar text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Avg Score</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($academicProgress['online_learning_stats']['average_score'], 1) }}%</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Progress & Online Learning Integration -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Academic Courses -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-university mr-2"></i>
                        Academic Courses
                    </h3>
                    <div class="space-y-3">
                        @foreach($academicProgress['academic_enrollments'] as $enrollment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $enrollment['course']->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $enrollment['course']->code }} • {{ $enrollment['credits'] }} credits</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $enrollment['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($enrollment['status']) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $enrollment['grade'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Online Learning Stats -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-laptop mr-2"></i>
                        Online Learning Activity
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Exams Taken</span>
                            <span class="text-sm font-medium">{{ $academicProgress['online_learning_stats']['exams_taken'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Lessons Completed</span>
                            <span class="text-sm font-medium">{{ $academicProgress['online_learning_stats']['lessons_completed'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Assignments Submitted</span>
                            <span class="text-sm font-medium">{{ $academicProgress['online_learning_stats']['assignments_submitted'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Certificates Earned</span>
                            <span class="text-sm font-medium">{{ $academicProgress['online_learning_stats']['certificates_earned'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Analytics & Recommendations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Learning Analytics -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-brain mr-2"></i>
                        AI Learning Analytics
                    </h3>
                    <div class="space-y-3">
                        @if(isset($analytics['performance_trends']))
                            <div class="p-3 bg-blue-50 rounded-md">
                                <p class="text-sm font-medium text-blue-900">Performance Trend</p>
                                <p class="text-xs text-blue-700">{{ $analytics['performance_trends']['trend'] ?? 'Steady improvement' }}</p>
                            </div>
                        @endif
                        
                        @if(isset($analytics['learning_style_analysis']))
                            <div class="p-3 bg-green-50 rounded-md">
                                <p class="text-sm font-medium text-green-900">Learning Style</p>
                                <p class="text-xs text-green-700">{{ $analytics['learning_style_analysis']['style'] ?? 'Visual learner' }}</p>
                            </div>
                        @endif
                        
                        @if(isset($analytics['engagement_metrics']))
                            <div class="p-3 bg-purple-50 rounded-md">
                                <p class="text-sm font-medium text-purple-900">Engagement Level</p>
                                <p class="text-xs text-purple-700">{{ $analytics['engagement_metrics']['level'] ?? 'High' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- AI Recommendations -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-magic mr-2"></i>
                        AI Recommendations
                    </h3>
                    <div class="space-y-3">
                        @if(isset($recommendations['prerequisite_courses']))
                            <div class="p-3 bg-yellow-50 rounded-md">
                                <p class="text-sm font-medium text-yellow-900 mb-2">Recommended Courses</p>
                                @foreach($recommendations['prerequisite_courses'] as $course)
                                    <p class="text-xs text-yellow-700">• {{ $course['name'] ?? 'Advanced Hospitality' }}</p>
                                @endforeach
                            </div>
                        @endif
                        
                        @if(isset($recommendations['skill_based_courses']))
                            <div class="p-3 bg-indigo-50 rounded-md">
                                <p class="text-sm font-medium text-indigo-900 mb-2">Skill Development</p>
                                @foreach($recommendations['skill_based_courses'] as $course)
                                    <p class="text-xs text-indigo-700">• {{ $course['name'] ?? 'Customer Service Excellence' }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Certificates -->
        @if($academicProgress['certifications']->isNotEmpty())
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-award mr-2"></i>
                        Recent Certificates
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($academicProgress['certifications']->take(6) as $certificate)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $certificate->title }}</h4>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ ucfirst($certificate->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mb-2">{{ $certificate->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">{{ $certificate->issue_date->format('M d, Y') }}</span>
                                    <a href="{{ route('certificates.show', $certificate) }}" class="text-blue-600 hover:text-blue-900 text-xs">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
