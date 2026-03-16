@extends('layouts.qbo')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-brain mr-3"></i>
                Academic Analytics
            </h1>
            <p class="text-gray-600 mt-2">AI-powered insights and learning analytics</p>
        </div>

        <!-- Analytics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Performance Trend</dt>
                                <dd class="text-lg font-medium text-gray-900">Improving</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-brain text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Learning Style</dt>
                                <dd class="text-lg font-medium text-gray-900">Visual</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-fire text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Engagement</dt>
                                <dd class="text-lg font-medium text-gray-900">High</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-trophy text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Skill Level</dt>
                                <dd class="text-lg font-medium text-gray-900">Advanced</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Performance Analytics -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-area mr-2"></i>
                        Performance Analytics
                    </h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-blue-50 rounded-md">
                            <p class="text-sm font-medium text-blue-900">Trend Analysis</p>
                            <p class="text-xs text-blue-700">Your performance has improved by 15% over the past month</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-md">
                            <p class="text-sm font-medium text-green-900">Strength Areas</p>
                            <p class="text-xs text-green-700">Customer Service, Hospitality Operations</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-md">
                            <p class="text-sm font-medium text-yellow-900">Improvement Areas</p>
                            <p class="text-xs text-yellow-700">Financial Management, Strategic Planning</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-md">
                            <p class="text-sm font-medium text-purple-900">Predictive Success</p>
                            <p class="text-xs text-purple-700">87% probability of completing current program on time</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Pattern Analysis -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-brain mr-2"></i>
                        Learning Pattern Analysis
                    </h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-indigo-50 rounded-md">
                            <p class="text-sm font-medium text-indigo-900">Optimal Study Time</p>
                            <p class="text-xs text-indigo-700">9:00 AM - 11:00 AM (Highest retention)</p>
                        </div>
                        <div class="p-3 bg-pink-50 rounded-md">
                            <p class="text-sm font-medium text-pink-900">Preferred Content Type</p>
                            <p class="text-xs text-pink-700">Video tutorials (73% completion rate)</p>
                        </div>
                        <div class="p-3 bg-cyan-50 rounded-md">
                            <p class="text-sm font-medium text-cyan-900">Learning Pace</p>
                            <p class="text-xs text-cyan-700">Moderate pace - 2-3 modules per week</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-md">
                            <p class="text-sm font-medium text-orange-900">Interaction Style</p>
                            <p class="text-xs text-orange-700">Collaborative learner - prefers group discussions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adaptive Learning Recommendations -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-magic mr-2"></i>
                    Adaptive Learning Path
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Current Focus</h4>
                        <p class="text-xs text-gray-600 mb-2">Advanced Customer Service</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">75% Complete</p>
                    </div>
                    
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Next Recommended</h4>
                        <p class="text-xs text-gray-600 mb-2">Hospitality Financial Management</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Ready to start</p>
                    </div>
                    
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Future Path</h4>
                        <p class="text-xs text-gray-600 mb-2">Strategic Hospitality Management</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Prerequisites needed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skill Development Tracking -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Skill Assessment -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-radar mr-2"></i>
                        Skill Assessment
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Customer Service</span>
                                <span class="text-gray-900 font-medium">92%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Operations Management</span>
                                <span class="text-gray-900 font-medium">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Financial Acumen</span>
                                <span class="text-gray-900 font-medium">68%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 68%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Leadership</span>
                                <span class="text-gray-900 font-medium">78%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Strategic Planning</span>
                                <span class="text-gray-900 font-medium">72%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Engagement Metrics -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-fire-alt mr-2"></i>
                        Engagement Metrics
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Daily Login Streak</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">12 days</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Study Time This Week</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">18.5 hours</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Course Progress Rate</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">2.3x faster</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Interaction Score</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">High</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Forum Participation</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Very Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Recommendations -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-lightbulb mr-2"></i>
                    AI-Powered Recommendations
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">
                            <i class="fas fa-book mr-2"></i>
                            Course Recommendation
                        </h4>
                        <p class="text-xs text-blue-700">Advanced Revenue Management - Based on your strong performance in financial modules</p>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                        <h4 class="text-sm font-medium text-green-900 mb-2">
                            <i class="fas fa-clock mr-2"></i>
                            Schedule Optimization
                        </h4>
                        <p class="text-xs text-green-700">Schedule challenging topics for morning sessions when your focus is highest</p>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                        <h4 class="text-sm font-medium text-purple-900 mb-2">
                            <i class="fas fa-users mr-2"></i>
                            Study Group Match
                        </h4>
                        <p class="text-xs text-purple-700">Join Advanced Hospitality study group - 3 students with similar learning patterns</p>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200">
                        <h4 class="text-sm font-medium text-yellow-900 mb-2">
                            <i class="fas fa-target mr-2"></i>
                            Skill Focus
                        </h4>
                        <p class="text-xs text-yellow-700">Focus on strategic planning - identified as key area for career advancement</p>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border border-red-200">
                        <h4 class="text-sm font-medium text-red-900 mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Intervention Alert
                        </h4>
                        <p class="text-xs text-red-700">Consider additional practice in financial management - performance dip detected</p>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border border-cyan-200">
                        <h4 class="text-sm font-medium text-cyan-900 mb-2">
                            <i class="fas fa-trophy mr-2"></i>
                            Achievement Ready
                        </h4>
                        <p class="text-xs text-cyan-700">You're ready for Customer Service Excellence certification</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
