<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.settings.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,gif,webp|max:256',
            'contact_email' => 'nullable|email|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'from_email' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'points' => 'nullable|string|max:255',
            'connecteam_api_key' => 'nullable|string|max:255',
        ];

        $messages = [
            'logo.max' => 'The logo must not be larger than 2MB.',
            'favicon.max' => 'The favicon must not be larger than 256KB.',
            'logo.image' => 'The logo must be an image file.',
            'favicon.image' => 'The favicon must be an image file.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, svg.',
            'favicon.mimes' => 'The favicon must be a file of type: ico, png, gif.',
            'contact_email.email' => 'Please enter a valid contact email address.',
            'smtp_port.integer' => 'The SMTP port must be a number.',
            'smtp_port.min' => 'The SMTP port must be at least 1.',
            'smtp_port.max' => 'The SMTP port must not be greater than 65535.',
            'smtp_port.max' => 'The SMTP port must not be greater than 65535.',
            'from_email.email' => 'Please enter a valid "From" email address.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        return $data;
        $timestamp = now()->format('Ymd_His');
        $destination = public_path('assets/img');
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . $timestamp . '.' . $logo->getClientOriginalExtension();
            $logo->move($destination, $logoName);
            $data['logo'] = 'assets/img/' . $logoName;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . $timestamp . '.' . $favicon->getClientOriginalExtension();
            $favicon->move($destination, $faviconName);
            $data['favicon'] = 'assets/img/' . $faviconName;
        }

        $data['maintenance_mode'] = $request->boolean('maintenance_mode');
        $data['points'] = $request->points;

        // Apply Laravel maintenance mode
        $data['maintenance_mode']
            ? Artisan::call('down')
            : Artisan::call('up');

        $setting = SettingsModel::create($data);
        $this->syncEnv($setting);
        return redirect()->back()->with('success', 'Settings saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = SettingsModel::findorfail($id);
        return view('Admin.settings.create', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $setting = SettingsModel::findOrFail($id);
        $rules = [
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,gif,webp',
            'contact_email' => 'nullable|email|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'from_email' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'connecteam_api_key' => 'nullable|string|max:255',
            'referrer_percent' => 'nullable|string|max:255',
        ];

        $messages = [
            'logo.max' => 'The logo must not be larger than 2MB.',
            // 'favicon.max' => 'The favicon must not be larger than 256KB.',
            'logo.image' => 'The logo must be an image file.',
            'favicon.image' => 'The favicon must be an image file.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, svg.',
            'favicon.mimes' => 'The favicon must be a file of type: ico, png, gif.',
            'contact_email.email' => 'Please enter a valid contact email address.',
            'smtp_port.integer' => 'The SMTP port must be a number.',
            'smtp_port.min' => 'The SMTP port must be at least 1.',
            'smtp_port.max' => 'The SMTP port must not be greater than 65535.',
            'from_email.email' => 'Please enter a valid "From" email address.',
        ];

        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        
        $data = $validator->validated();

        $destination = public_path('assets/img');
        $timestamp = now()->format('Ymd_His');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }

            $logo = $request->file('logo');
            $logoName = 'logo_' . $timestamp . '.' . $logo->getClientOriginalExtension();
            $logo->move($destination, $logoName);
            $data['logo'] = 'assets/img/' . $logoName;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                unlink(public_path($setting->favicon));
            }

            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . $timestamp . '.' . $favicon->getClientOriginalExtension();
            $favicon->move($destination, $faviconName);
            $data['favicon'] = 'assets/img/' . $faviconName;
        }

        // Maintenance mode toggle
        $data['maintenance_mode'] = $request->boolean('maintenance_mode');
        $data['maintenance_mode'] ? Artisan::call('down') : Artisan::call('up');
        
        $data['points'] = $request->points;
        $data['referrer_percent'] = $request->referrer_percent;
        // Update settings
        $setting->update($data);
        $this->syncEnv($setting);


        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function syncEnv()
    {
        $settings = SettingsModel::first();

        if (!$settings) {
            return back()->with('error', 'No settings found to sync.');
        }

        $envUpdates = [
            'APP_NAME'           => $settings->site_name ?? 'Affinity',
            'MAIL_HOST'          => $settings->smtp_host ?? '',
            'MAIL_PORT'          => $settings->smtp_port ?? '',
            'MAIL_USERNAME'      => $settings->smtp_username ?? '',
            'MAIL_PASSWORD'      => $settings->smtp_password ?? '',
            'MAIL_FROM_ADDRESS'  => $settings->from_email ?? '',
            'MAIL_FROM_NAME'     => $settings->from_name ?? '',
            'CONNECTEAM_API_KEY' => $settings->connecteam_api_key ?? '',
        ];

        $this->updateEnvFile($envUpdates);

        // Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return back()->with('success', '.env file synced successfully!');
    }

    private function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            throw new \Exception(".env file not found!");
        }
        $envContent = File::get($envPath);
        foreach ($data as $key => $value) {
            // Escape characters like quotes
            $escapedValue = '"' . addslashes($value) . '"';
            // Regex to find existing key (handles values with or without quotes)
            $pattern = "/^{$key}=.*$/m";
            if (preg_match($pattern, $envContent)) {
                // Replace existing key
                $envContent = preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
            } else {
                // Append new key at the end
                $envContent .= "\n{$key}={$escapedValue}";
            }
        }
        // Write the updated content back to .env
        File::put($envPath, $envContent);
    }

    public function runCommand(Request $request)
    {
        Artisan::call('app:calculate-weekly-connecteam-hours');
        return back()->with('success', 'Command executed successfully!');
    }
}
