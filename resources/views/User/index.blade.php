@extends('Layouts.userLayout')
@section('pageName', 'Dashboard | User')

@section('content')

    <main id="main" class="main">
        @include('User.includes.alerts')
        <div class="pagetitle">
            {{-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h1>Hello {{ $user->first_name . ' ' . $user->last_name }}, welcome to your dashboard!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> --}}
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Points</h5>
                                <span><button type="button" class="btn btn-sm rounded-pill"
                                        style="background-color: #e0f8e9;color:#2eca6a" data-bs-toggle="modal"
                                        data-bs-target="#withdrawmodal">Withdraw</button>
                                </span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $amount }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Referred Users</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $referred_users }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="modal fade" id="withdrawmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Withdraw Amount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('payout.request') }}">
                        
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="amountInput" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amountInput" name="amountInput" placeholder="e.g., 100.00"
                                    step="0.01" min="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

@endsection
