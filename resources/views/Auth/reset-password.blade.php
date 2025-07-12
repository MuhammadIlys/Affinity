@extends('Layouts.authLayout')
@section('pageName', 'Reset Password')
@section('content')
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        style="background-image: url('{{ asset('assets/img/login.jpg') }}'); background-size:cover; background-position:center">
        <div class="container">



            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title pb-0 fs-4">Reset Password</h5>
                                <p class="small">Please enter new Password</p>
                            </div>

                            <form class="row g-3" action="{{ route('password.update') }}" method="post">
                                @csrf


                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="col-12">
                                    <label for="password" class="form-label">password</label>
                                    <div class="input-group has-validation">
                                        <input type="password" name="password"
                                            class="form-control" id="password" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label">Confirm password</label>
                                    <div class="input-group has-validation">
                                        <input type="password_confirmation" name="password_confirmation"
                                            class="form-control" id="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    @include('Admin.includes.alerts')

                </div>
            </div>
        </div>

    </section>
@endsection
