@extends('Layouts.adminlayout')
@section('pageName', 'Details | Admin')

@section('content')

    <main id="main" class="main">
        @include('Admin.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="card p-4">
                            <div class="card-body">
                                <div class="col-12">
                                    {{-- <h6 style="font-size: 30px; font-weight:700; border-left:5px solid blue" class="text-secondary ps-3 mb-3"> Employee details </h6> --}}
                                    <div class="d-flex flex-row gap-3">

                                        <div class="d-flex justify-content-center justify-content-lg-start">
                                            <img class="img" src="{{ asset($referrer->image) }}"
                                                style="width:150px; height:150px; border-radius:100px" alt="">

                                        </div>
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div>
                                                <h6 style="font-size: 30px; font-weight:700" class="text-secondary">
                                                    {{ $referrer->first_name . ' ' . $referrer->last_name }}<b></b> </h6>
                                                {{-- <h6 style="font-size: 15px; font-weight:500" class="text-secondary">CEO</h6> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-lg-row gap-3 mt-4">

                                        <div class="card info-card sales-card m-0 p-0">
                                            <div class="card-body p-3 ">
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height:50px">
                                                        <i class="ri-mail-line"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6 style="font-size: 16px; font-weight:600" class="me-2">
                                                            {{ $referrer->email }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card info-card sales-card m-0 p-0">
                                            <div class="card-body p-3 ">
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height:50px">
                                                        <i class="bi bi-person-bounding-box"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6 style="font-size: 16px; font-weight:600" class="me-2">
                                                            Software Engineer</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card info-card sales-card m-0 p-0">
                                            <div class="card-body p-3 ">
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height:50px">
                                                        <i class="bi bi-telephone-plus"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6 style="font-size: 16px; font-weight:600">{{ $referrer->phone }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card info-card sales-card m-0 p-0">
                                            <div class="card-body p-3 ">
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height:50px">
                                                        <i class="bi bi-aspect-ratio-fill"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6 style="font-size: 16px; font-weight:600" class="me-2">
                                                            {{ $referrer->total_amount }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div><!-- End Left side columns -->
            </div>
        </section>

    </main><!-- End #main -->

@endsection
