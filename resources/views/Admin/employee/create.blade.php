@extends('Layouts.adminlayout')
@section('pageName', 'Dashboard | Employees')

@section('content')

    <main id="main" class="main">
        @include('Admin.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Employees</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" method="POST"
                                action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}">
                                @csrf

                                @if (isset($employee))
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
                                        value="{{ old('first_name', $employee->first_name ?? '') }}"
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
                                        value="{{ old('last_name', $employee->last_name ?? '') }}"
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
                                        value="{{ old('email', $employee->email ?? '') }}" placeholder="johndoe@gmail.com">
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
                                            {{ old('gender', $employee->gender ?? '') == '' ? 'selected' : '' }}>Gender
                                        </option>
                                        <option value="male"
                                            {{ old('gender', $employee->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $employee->gender ?? '') == 'female' ? 'selected' : '' }}>
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
                                        value="{{ old('job_title', $employee->job_title ?? '') }}"
                                        placeholder="eg: John Doe">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="phone" class="form-label">
                                        Phone <small class="text-danger">( No spaces or signs allowed )</small>
                                        @error('phone')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $employee->phone ?? '') }}" placeholder="eg: +123345677">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="dob" class="form-label">
                                        DOB
                                        @error('dob')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="date" class="form-control" id="dob" name="dob"
                                        value="{{ old('dob', $employee->dob ?? '') }}">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="address" class="form-label">
                                        Address
                                        @error('address')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', $employee->address ?? '') }}" placeholder="1234 Main St">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="gender" class="form-label">
                                        Referred By
                                        @error('gender')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <select class="form-select" name="referred_by" aria-label="referred_by select">
                                        @if ($referrers)
                                            @foreach ($referrers as $referrer)
                                                <option value="{{ $referrer->id }}">
                                                    {{ $referrer->first_name . $referrer->last_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="status" class="form-label">
                                        Status
                                        @error('status')
                                            <small class="text-danger">({{ $message }})</small>
                                        @enderror
                                    </label>
                                    <select class="form-select" name="status" aria-label="Select">
                                        <option value="active"
                                            {{ old('status', $employee->status ?? '') == 'active' ? 'selected' : '' }}>active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $employee->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>

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
