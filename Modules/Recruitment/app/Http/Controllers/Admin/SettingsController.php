<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('recruitment::admin.settings.index', [
            'settings' => [
                'site_name' => config('app.name'),
                'site_description' => config('app.description'),
                'contact_email' => config('mail.from.address'),
                'timezone' => config('app.timezone'),
                'date_format' => config('app.date_format'),
                'enable_registration' => config('app.enable_registration', true),
                'enable_notifications' => config('app.enable_notifications', true),
            ]
        ]);
    }

    /**
     * Update the application settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:1000'],
            'contact_email' => ['required', 'email', 'max:255'],
            'timezone' => ['required', 'string', 'timezone'],
            'date_format' => ['required', 'string', 'in:Y-m-d,d/m/Y,m/d/Y'],
            'enable_registration' => ['boolean'],
            'enable_notifications' => ['boolean'],
        ]);

        // Update settings in the database or config file
        foreach ($validated as $key => $value) {
            Cache::put("setting.{$key}", $value);
        }

        return redirect()->route('admin.settings')->with('status', 'settings-updated');
    }
}
