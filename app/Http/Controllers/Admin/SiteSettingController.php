<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::pluck('value', 'key')->all();

        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_button_text' => 'nullable|string|max:100',
            'hero_secondary_button_text' => 'nullable|string|max:100',
            'profile_intro' => 'nullable|string|max:1000',
            'rfc_intro' => 'nullable|string|max:1000',
            'services_intro' => 'nullable|string|max:1000',
            'guide_intro' => 'nullable|string|max:1000',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:100',
            'sop_intro' => 'nullable|string|max:1000',
            'contact_intro' => 'nullable|string|max:1000',
            'footer_text' => 'nullable|string|max:500',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return redirect()->route('admin.site-settings.edit')->with('success', 'Pengaturan halaman publik berhasil disimpan.');
    }
}
