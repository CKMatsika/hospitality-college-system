<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function edit()
    {
        $settings = SystemSetting::current();

        return view('system-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SystemSetting::current();

        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'institution_tagline' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'theme' => 'required|in:light,dark',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
        ]);

        $settings->update($validated);

        return redirect()->route('system-settings.edit')
            ->with('success', 'System settings updated successfully.');
    }
}
