@extends('Layouts.adminlayout')
@section('pageName', 'Dashboard | Settings')

@section('content')

    <main id="main" class="main">
        @include('Admin.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="container py-4">
                            <form
                                action="@isset($settings) {{ route('settings.update', $settings->id) }} @else {{ route('settings.store') }} @endisset"
                                method="POST" enctype="multipart/form-data">

                                @csrf
                                @isset($settings)
                                    @method('PUT')
                                @endisset

                                <!-- General Settings -->
                                <div class="card mb-4 ">
                                    <div class="card-header bg-primary text-white">General Settings</div>
                                    <div class="card-body mt-4">
                                        <div class="mb-3 ">
                                            <label for="site_name" class="form-label">Site Name</label>
                                            <input type="text" class="form-control" id="site_name" name="site_name"
                                                value="{{ old('site_name', $settings->site_name ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="logo" class="form-label">Logo</label>
                                            <input class="form-control" type="file" id="logo" name="logo">

                                            @isset($settings->logo)
                                                <div class="mt-2">
                                                    <img src="{{ asset($settings->logo) }}" alt="Current logo"
                                                        height="100">
                                                </div>
                                            @endisset
                                        </div>
                                        <div class="mb-3">
                                            <label for="favicon" class="form-label">Favicon</label>
                                            <input class="form-control" type="file" id="favicon" name="favicon">
                                            @isset($settings->favicon)
                                                <div class="mt-2">
                                                    <img src="{{ asset($settings->favicon) }}"
                                                        alt="Current Favicon" height="100">
                                                </div>
                                            @endisset
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_email" class="form-label">Contact Email</label>
                                            <input type="email" class="form-control" id="contact_email"
                                                name="contact_email"
                                                value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                 <div class="card mb-4">
                                    <div class="card-header  bg-info text-dark">Points per hour</div>
                                    <div class="card-body mt-4">
                                        <div class="mb-3">
                                            <label for="points" class="form-label">Enter points per hour</label>
                                            <input type="text" class="form-control" id="points"
                                                name="points"
                                                value="{{ old('points', $settings->points ?? '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="referrer_percent" class="form-label">Referrer percent</label>
                                            <input type="text" class="form-control" id="referrer_percent"
                                                name="referrer_percent"
                                                value="{{ old('referrer_percent', $settings->referrer_percent ?? '') }}">
                                                {{-- value="0" > --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- Email SMTP Settings -->
                                <div class="card mb-4">
                                    <div class="card-header  bg-success text-white">Email (SMTP) Settings</div>
                                    <div class="card-body mt-4">
                                        <div class="mb-3">
                                            <label for="smtp_host" class="form-label">SMTP Host</label>
                                            <input type="text" class="form-control" id="smtp_host" name="smtp_host"
                                                value="{{ old('smtp_host', $settings->smtp_host ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="smtp_port" class="form-label">SMTP Port</label>
                                            <input type="number" class="form-control" id="smtp_port" name="smtp_port"
                                                value="{{ old('smtp_port', $settings->smtp_port ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="smtp_username" class="form-label">SMTP Username</label>
                                            <input type="text" class="form-control" id="smtp_username"
                                                name="smtp_username"
                                                value="{{ old('smtp_username', $settings->smtp_username ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="smtp_password" class="form-label">SMTP Password</label>
                                            <input type="password" class="form-control" id="smtp_password"
                                                name="smtp_password"
                                                value="{{ old('smtp_password', $settings->smtp_password ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="from_email" class="form-label">From Email</label>
                                            <input type="email" class="form-control" id="from_email" name="from_email"
                                                value="{{ old('from_email', $settings->from_email ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="from_name" class="form-label">From Name</label>
                                            <input type="text" class="form-control" id="from_name" name="from_name"
                                                value="{{ old('from_name', $settings->from_name ?? '') }}">
                                        </div>

                                        <button type="button" class="btn btn-outline-secondary">Send Test Email</button>
                                    </div>
                                </div>

                                <!-- API Keys Management -->
                                <div class="card mb-4">
                                    <div class="card-header  bg-dark text-white">API Keys Management</div>
                                    <div class="card-body mt-4">
                                        <div class="mb-3">
                                            <label for="connecteam_api_key" class="form-label">Connecteam API Key</label>
                                            <input type="text" class="form-control" id="connecteam_api_key"
                                                name="connecteam_api_key"
                                                value="{{ old('connecteam_api_key', $settings->connecteam_api_key ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end mb-5">
                                    <button type="submit" class="btn btn-primary">
                                        @isset($settings)
                                            Update Settings
                                        @else
                                            Save Settings
                                        @endisset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

@endsection
