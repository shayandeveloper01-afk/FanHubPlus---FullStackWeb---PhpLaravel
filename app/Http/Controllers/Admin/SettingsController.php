<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\LogsAdminActivity;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    use LogsAdminActivity;

    // Keys managed by the settings form (whitelist prevents arbitrary key injection)
    private const KEYS = [
        'site_name',
        'contact_email',
        'chatbot_fallback_message',
        'maintenance_mode',
        'feedback_categories',
    ];

    public function index(): View
    {
        $settings = SiteSetting::whereIn('key', self::KEYS)
            ->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name'                => 'nullable|string|max:100',
            'contact_email'            => 'nullable|email|max:150',
            'chatbot_fallback_message' => 'nullable|string|max:500',
            'maintenance_mode'         => 'nullable|boolean',
            'feedback_categories'      => 'nullable|string|max:500',
        ]);

        foreach (self::KEYS as $key) {
            // maintenance_mode: treat missing checkbox as false
            $value = $key === 'maintenance_mode'
                ? ($request->boolean('maintenance_mode') ? '1' : '0')
                : ($data[$key] ?? null);

            SiteSetting::set($key, $value);
        }

        $this->auditLog('settings.update', null, null, 'Site settings updated');

        return back()->with('success', 'Settings saved.');
    }
}
