@extends('layouts.qbo')

@section('title', 'System Settings')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-cog mr-2"></i>
            System Settings
        </h1>
        <p class="text-gray-600 mt-2">Configure system-wide settings and preferences.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="text-green-800 text-sm">{{ session('success') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('system-settings.update') }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Institution Details</h3>
                            <p class="text-sm text-gray-500">These details will appear on printable documents like receipts and invoices.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="institution_name" class="block text-sm font-medium text-gray-700">Institution Name</label>
                                <input type="text" id="institution_name" name="institution_name" value="{{ old('institution_name', $settings->institution_name) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('institution_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="institution_tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                                <input type="text" id="institution_tagline" name="institution_tagline" value="{{ old('institution_tagline', $settings->institution_tagline) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('institution_tagline')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="address" name="address" rows="3"
                                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $settings->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $settings->phone) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $settings->email) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="text" id="website" name="website" value="{{ old('website', $settings->website) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('website')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t pt-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Appearance</h3>
                                <p class="text-sm text-gray-500">Basic UI customization settings.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                <div>
                                    <label for="theme" class="block text-sm font-medium text-gray-700">Theme</label>
                                    <select id="theme" name="theme" required
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="light" {{ old('theme', $settings->theme) === 'light' ? 'selected' : '' }}>Light</option>
                                        <option value="dark" {{ old('theme', $settings->theme) === 'dark' ? 'selected' : '' }}>Dark</option>
                                    </select>
                                    @error('theme')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="primary_color" class="block text-sm font-medium text-gray-700">Primary Color</label>
                                    <input type="text" id="primary_color" name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}" required
                                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('primary_color')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="secondary_color" class="block text-sm font-medium text-gray-700">Secondary Color</label>
                                    <input type="text" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color) }}" required
                                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('secondary_color')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
