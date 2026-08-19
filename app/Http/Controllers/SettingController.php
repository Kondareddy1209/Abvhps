<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Admin Global Settings Desk
     */
    public function adminIndex()
    {
        $settings = [
            'site_title' => SiteSetting::get('site_title', 'ABVHPS - Akhanda Bharatha Viswa Hindu Parirakshana Samiti'),
            'contact_phone' => SiteSetting::get('contact_phone', '+91 8884933379'),
            'whatsapp_number' => SiteSetting::getWhatsAppNumber(),
            'contact_email' => SiteSetting::get('contact_email', 'info@abvhps.org'),
            'contact_address' => SiteSetting::get('contact_address', 'Survey No:1826, Shanmukhapuram, Akkalareddy Palli Village and Post, Porumamilla Mandalam, Kadapa, A.P - 516193'),
            'facebook_url' => SiteSetting::get('facebook_url', 'https://facebook.com/abvhps'),
            'twitter_url' => SiteSetting::get('twitter_url', 'https://twitter.com/abvhps'),
            'youtube_url' => SiteSetting::get('youtube_url', 'https://youtube.com/@abvhps'),
            'footer_about' => SiteSetting::get('footer_about', 'Dedicated to preserving and promoting Hindu culture and values worldwide under the behest of Rajaguru Sri Sri Sri Subrahmanneswara Swamy Garu.'),
            'membership_fee' => SiteSetting::get('membership_fee', '100.00'),
            'volunteer_fee' => SiteSetting::get('volunteer_fee', '150.00'),
        ];

        return view('admin.settings_index', compact('settings'));
    }

    /**
     * Admin Update Global Settings
     */
    public function adminUpdate(Request $request)
    {
        $rules = [
            'site_title' => 'string|max:255',
            'contact_phone' => 'string|max:50',
            'whatsapp_number' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[\+]?[0-9\s\-\(\)]+$/',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/[^0-9]/', '', (string)$value);
                    if (strlen($digits) < 10 || strlen($digits) > 15) {
                        $fail('The WhatsApp number must contain between 10 and 15 digits.');
                    }
                }
            ],
            'contact_email' => 'email|max:100',
            'contact_address' => 'string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'footer_about' => 'string|max:1000',
        ];

        $request->validate($rules);

        foreach (array_keys($rules) as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        // Handle Custom Logo Upload
        if ($request->hasFile('site_logo')) {
            $request->validate(['site_logo' => 'image|max:2048']);
            $logoPath = $request->file('site_logo')->storeAs('images', 'logo.png', 'public');
            // Also copy to public/images/logo.png
            copy(storage_path('app/public/images/logo.png'), public_path('images/logo.png'));
            SiteSetting::set('site_logo', 'images/logo.png');
        }

        // Handle Custom Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $request->validate(['site_favicon' => 'image|max:1024']);
            $favPath = $request->file('site_favicon')->storeAs('images', 'favicon.png', 'public');
            copy(storage_path('app/public/images/favicon.png'), public_path('favicon.png'));
            copy(storage_path('app/public/images/favicon.png'), public_path('favicon.ico'));
            SiteSetting::set('site_favicon', 'favicon.png');
        }

        return redirect()->route('admin.settings.index')->with('success', 'Global Site Settings updated and synced across all pages.');
    }
}
