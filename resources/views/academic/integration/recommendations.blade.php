@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-magic mr-3"></i>
                AI-Powered Recommendations
            </h1>
            <p class="text-gray-600 mt-2">Personalized course and learning recommendations for {{ $student->full_name }}</p>
        </div>

        <!-- Student Overview -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 bg-blue-500 rounded-full p-3">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $student->full_name }}</h3>
                        <p class="text-sm text-gray-500">Student ID: {{ $student->student_id }}</p>
                        @if($student->program)
                            <p class="text-sm text-gray-500">Program: {{ $student->program->name }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">3.2</div>
                        <div class="text-sm text-gray-500">Current GPA</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $student->enrollments->count() }}</div>
                        <div class="text-sm text-gray-500">Active Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">85%</div>
                        <div class="text-sm text-gray-500">Completion Rate</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">Visual</div>
                        <div class="text-sm text-gray-500">Learning Style</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Recommendations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Course Recommendations -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-book mr-2"></i>
                        Recommended Courses
                    </h3>
                    <div class="space-y-4">
                        @if(isset($recommendations['prerequisite_courses']))
                            @foreach($recommendations['prerequisite_courses'] as $course)
                                <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $course['name'] ?? 'Advanced Hospitality Management' }}</h4>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Recommended
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-2">{{ $course['description'] ?? 'Builds on your current knowledge and skills' }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">{{ $course['credits'] ?? '3' }} credits</span>
                                        <button class="text-blue-600 hover:text-blue-900 text-xs">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Learn More
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                        @if(isset($recommendations['skill_based_courses']))
                            @foreach($recommendations['skill_based_courses'] as $course)
                                <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $course['name'] ?? 'Customer Service Excellence' }}</h4>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Skill Development
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-2">{{ $course['description'] ?? 'Enhances your customer service capabilities' }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">{{ $course['credits'] ?? '2' }} credits</span>
                                        <button class="text-blue-600 hover:text-blue-900 text-xs">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Learn More
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Learning Path Recommendations -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-route mr-2"></i>
                        Learning Path Suggestions
                    </h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">
                                <i class="fas fa-trophy mr-2"></i>
                                Advanced Hospitality Track
                            </h4>
                            <p class="text-xs text-blue-700 mb-3">Based on your strong performance in foundational courses</p>
                            <div class="space-y-2">
                                <div class="flex items-center text-xs text-blue-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Strategic Hospitality Management
                                </div>
                                <div class="flex items-center text-xs text-blue-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Advanced Revenue Management
                                </div>
                                <div class="flex items-center text-xs text-blue-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Hospitality Analytics
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                            <h4 class="text-sm font-medium text-green-900 mb-2">
                                <i class="fas fa-users mr-2"></i>
                                Management Leadership Track
                            </h4>
                            <p class="text-xs text-green-700 mb-3">Develop your leadership and management capabilities</p>
                            <div class="space-y-2">
                                <div class="flex items-center text-xs text-green-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Team Leadership in Hospitality
                                </div>
                                <div class="flex items-center text-xs text-green-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Hospitality Operations Management
                                </div>
                                <div class="flex items-center text-xs text-green-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Service Quality Management
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                            <h4 class="text-sm font-medium text-purple-900 mb-2">
                                <i class="fas fa-chart-line mr-2"></i>
                                Business Development Track
                            </h4>
                            <p class="text-xs text-purple-700 mb-3">Focus on business growth and development strategies</p>
                            <div class="space-y-2">
                                <div class="flex items-center text-xs text-purple-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Hospitality Marketing Strategies
                                </div>
                                <div class="flex items-center text-xs text-purple-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Business Planning for Hospitality
                                </div>
                                <div class="flex items-center text-xs text-purple-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Entrepreneurship in Hospitality
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personalized Insights -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-brain mr-2"></i>
                    Personalized Learning Insights
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <h4 class="text-sm font-medium text-green-900 mb-3">
                            <i class="fas fa-star mr-2"></i>
                            Your Strengths
                        </h4>
                        <div class="space-y-2">
                            <div class="flex items-center text-xs text-green-700">
                                <i class="fas fa-check mr-2"></i>
                                Customer Service Excellence
                            </div>
                            <div class="flex items-center text-xs text-green-700">
                                <i class="fas fa-check mr-2"></i>
                                Operational Efficiency
                            </div>
                            <div class="flex items-center text-xs text-green-700">
                                <i class="fas fa-check mr-2"></i>
                                Team Collaboration
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <h4 class="text-sm font-medium text-yellow-900 mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Areas for Improvement
                        </h4>
                        <div class="space-y-2">
                            <div class="flex items-center text-xs text-yellow-700">
                                <i class="fas fa-arrow-up mr-2"></i>
                                Financial Management
                            </div>
                            <div class="flex items-center text-xs text-yellow-700">
                                <i class="fas fa-arrow-up mr-2"></i>
                                Strategic Planning
                            </div>
                            <div class="flex items-center text-xs text-yellow-700">
                                <i class="fas fa-arrow-up mr-2"></i>
                                Data Analysis
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h4 class="text-sm font-medium text-blue-900 mb-3">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Learning Style
                        </h4>
                        <div class="space-y-2">
                            <div class="flex items-center text-xs text-blue-700">
                                <i class="fas fa-eye mr-2"></i>
                                Visual Learner
                            </div>
                            <div class="flex items-center text-xs text-blue-700">
                                <i class="fas fa-users mr-2"></i>
                                Collaborative Learning
                            </div>
                            <div class="flex items-center text-xs text-blue-700">
                                <i class="fas fa-clock mr-2"></i>
                                Morning Sessions (9-11 AM)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Items -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-tasks mr-2"></i>
                    Recommended Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-book-open mr-2 text-blue-500"></i>
                            Immediate Actions
                        </h4>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li>• Enroll in Advanced Customer Service course</li>
                            <li>• Schedule morning study sessions for optimal learning</li>
                            <li>• Join study groups for collaborative learning</li>
                            <li>• Focus on financial management fundamentals</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-calendar-alt mr-2 text-green-500"></i>
                            Long-term Goals
                        </h4>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li>• Complete Advanced Hospitality Track</li>
                            <li>• Develop leadership and management skills</li>
                            <li>• Gain certification in Revenue Management</li>
                            <li>• Build strong financial acumen</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-play mr-2"></i>
                        Start Learning Path
                    </button>
                    <button class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-download mr-2"></i>
                        Download Recommendations
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
