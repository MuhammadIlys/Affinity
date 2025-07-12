@extends('Layouts.adminlayout')
@section('pageName', 'Profile | Admin')

@section('content')

    <main id="main" class="main">
        @include('Admin.includes.alerts')
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">

                        <div class="card-body p-5">
                            <div class="d-flex flex-row align-items-center gap-4">
                                <img src="http://127.0.0.1:8000/assets/img/placeholder.jpeg" alt="Profile"
                                    class="rounded-circle border border-2 border-primary" style="width:100px; height:100px">
                                <div>
                                    <h3 class="fw-bolder text-secondary">Emmanuel John</h3>
                                    <h6 class="fw-bold text-secondary">CEO</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"
                                        aria-selected="true" role="tab">Personal Information</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit"
                                        aria-selected="false" role="tab" tabindex="-1">Edit Profile</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"
                                        aria-selected="false" tabindex="-1" role="tab">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade profile-overview active show" id="profile-overview"
                                    role="tabpanel">

                                    <div class=" p-5">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <h5>First Name</h5>
                                                    <h5>{{ $user->first_name }}</h5>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h5>Last Name</h5>
                                                    <h5>{{ $user->last_name }}</h5>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h5>Email</h5>
                                                    <h5>{{ $user->email }}</h5>
                                                </div>

                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-12 col-lg-4">
                                                    <h5>Address</h5>
                                                    <h5>{{ $user->address }}</h5>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h5>Gender</h5>
                                                    <h5>{{ $user->gender }}</h5>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h5>Date of birth</h5>
                                                    <h5>{{ $user->dob }}</h5>
                                                </div>

                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-12 col-lg-4">
                                                    <h5>Job title</h5>
                                                    <h5>{{ $user->job_title }}</h5>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h5>Phone</h5>
                                                    <h5>{{ $user->phone }}</h5>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h5>Role</h5>
                                                    <h5>{{ $user->role }}</h5>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">
                                    <div class="p-5">
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('admin.profile.save') }}">
                                                @csrf

                                                <div class="row">
                                                    {{-- First Name --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="first_name" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" id="first_name"
                                                            name="first_name" value="{{ $user->first_name }}">
                                                        @error('first_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    {{-- Last Name --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="last_name" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control " id="last_name"
                                                            name="last_name" value="{{ $user->last_name }}">
                                                        @error('last_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div> {{-- End of row for First Name & Last Name --}}

                                                <div class="row">
                                                    {{-- Email Address --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="email" class="form-label">Email address</label>
                                                        <input type="email" class="form-control " id="email"
                                                            name="email" value="{{ $user->email }}"
                                                            aria-describedby="emailHelp">

                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    {{-- Phone Number (placed next to Email) --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone" class="form-label">Phone Number</label>
                                                        <input type="tel" class="form-control" id="phone"
                                                            name="phone" value="{{ $user->phone }}">
                                                        @error('phone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div> {{-- End of row for Email & Phone --}}

                                                {{-- Address (full width) --}}
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea class="form-control " id="address" name="address" rows="3">{{ $user->address }}</textarea>
                                                    @error('address')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    {{-- Gender --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="gender" class="form-label">Gender</label>
                                                        <select class="form-select " id="gender" name="gender">
                                                            <option value="">Select Gender</option>
                                                            <option value="male"
                                                                {{ $user->gender == 'male' ? 'selected' : '' }}>Male
                                                            </option>
                                                            <option value="female"
                                                                {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                                            </option>
                                                        </select>
                                                        @error('gender')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    {{-- Date of Birth --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="dob" class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control" id="dob"
                                                            name="dob" value="{{ $user->dob }}">
                                                        @error('dob')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select class="form-select" id="role" name="role">
                                                        <option value="">Select Role</option>
                                                        <option value="admin"
                                                            {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                        </option>
                                                        <option value="User"
                                                            {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                                    <!-- Change Password Form -->

                                    <form action="{{ route('password.change') }}" method="POST">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="currentPassword">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control"
                                                    id="newPassword">
                                                @error('newpassword')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control"
                                                    id="renewPassword">
                                                @error('renewpassword')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form>


                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>
                </div>

                {{-- <div class="col-12 col-lg-12">
                    <div class="card p-5">
                        <div class="card-header bg-transparent border-0 d-flex justify-content-between">
                            <h5 class="mb-2">Personal Information</h5>
                            <span><a href="" class="btn btn-sm btn-primary ps-3 pe-3">Edit</a></span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <h5>First Name</h5>
                                    <h5>Admin</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Last Name</h5>
                                    <h5>Admin</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Email</h5>
                                    <h5>admin@demo.com</h5>
                                </div>

                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-lg-4">
                                    <h5>Address</h5>
                                    <h5>Islamabad Pakistan</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Gender</h5>
                                    <h5>Male</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Date of birth</h5>
                                    <h5>05-03-2000</h5>
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-lg-4">
                                    <h5>Job title</h5>
                                    <h5>Chief Exigtive Officer</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Phone</h5>
                                    <h5>02436728374</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Role</h5>
                                    <h5>Admin</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> --}}

            </div>
        </section>

    </main><!-- End #main -->

@endsection
