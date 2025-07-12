@extends('Layouts.adminlayout')
@section('pageName', 'Dashboard | Referrer')

@section('content')

    <main id="main" class="main">
        @include('Admin.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Referrer</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Create Referrer</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" method="POST"
                                action="{{ isset($referrer) ? route('referrers.update', $referrer->id) : route('referrers.store') }}">
                                @csrf

                                @if (isset($referrer))
                                    @method('PUT')
                                @endif

                                <div class="col-12 col-lg-6">
                                    <label for="first_name" class="form-label">
                                        First Name
                                        @error('first_name')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name', $referrer->first_name ?? '') }}"
                                        placeholder="eg: John Doe">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="last_name" class="form-label">
                                        Last Name
                                        @error('last_name')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name', $referrer->last_name ?? '') }}"
                                        placeholder="eg: John Doe">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="email" class="form-label">
                                        Email
                                        @error('email')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $referrer->email ?? '') }}" placeholder="johndoe@gmail.com">
                                </div>

                                
<div class="col-12 col-lg-6">
                                    <label for="gender" class="form-label">
                                        Gender
                                        @error('gender')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <select class="form-select" name="gender" aria-label="Gender select">
                                        <option value="" disabled
                                            {{ old('gender', $referrer->gender ?? '') == '' ? 'selected' : '' }}>Gender
                                        </option>
                                        <option value="male"
                                            {{ old('gender', $referrer->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $referrer->gender ?? '') == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                </div>


                                <div class="col-12 col-lg-6">
                                    <label for="job_title" class="form-label">
                                        Job Title
                                        @error('job_title')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="job_title" name="job_title"
                                        value="{{ old('job_title', $referrer->job_title ?? '') }}"
                                        placeholder="eg: John Doe">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="phone" class="form-label">
                                        Phone
                                        @error('phone')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $referrer->phone ?? '') }}" placeholder="eg: +123345677">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="dob" class="form-label">
                                        DOB
                                        @error('dob')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="date" class="form-control" id="dob" name="dob"
                                        value="{{ old('dob', $referrer->dob ?? '') }}">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="address" class="form-label">
                                        Address
                                        @error('address')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', $referrer->address ?? '') }}" placeholder="1234 Main St">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="status" class="form-label">
                                        Status
                                        @error('status')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <select class="form-select" name="status" aria-label="status select">
                                        <option value="active"
                                            {{ @$referrer->status == 'active' ?? 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="suspended"
                                          {{ @$referrer->status == 'suspended' ?? 'suspended' ? 'selected' : '' }}>Suspended
                                        </option>
                                        <option value="blacklisted"
                                            {{ @$referrer->status == 'blacklisted' ?? 'blacklisted' ? 'selected' : '' }}>
                                            Blacklisted</option>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="password" class="form-label">
                                        Password
                                        @error('password')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        {{ isset($referrer) ? '' : 'required' }}>
                                    @if (isset($referrer))
                                        <small class="text-muted">Leave blank to keep current password</small>
                                    @endif
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div><!-- End Left side columns -->
            </div>
        </section>

    </main><!-- End #main -->

@endsection
