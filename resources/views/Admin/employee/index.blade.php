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
                    <div class="row">

                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body pt-3 table-responsive">
                                    <div class="my-3">
                                        <span class="card-title">Employees</span>
                                    </div>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">#No</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">First Name</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Last Name</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Referred By</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Email</button></th>
                                                <th scope="col" data-sortable="true"><button class="datatable-sorter">Job
                                                        Title</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Address</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Phone</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Balance</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">DOB</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Status</button></th>
                                                <th scope="col" data-sortable="true"><button
                                                        class="datatable-sorter">Action</button></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @if ($employees)
                                                @foreach ($employees as $employees)
                                                    <tr class="text-start">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $employees->first_name }}</td>
                                                        <td>{{ $employees->last_name }}</td>
                                                        <td>{{ $employees->referrer->first_name . ' ' . $employees->referrer->last_name }}
                                                        </td>
                                                        <td>{{ $employees->email }}</td>
                                                        <td>{{ $employees->job_title }}</td>
                                                        <td>{{ $employees->address }}</td>
                                                        <td>{{ $employees->phone }}</td>
                                                        <td>{{ $employees->total_amount }}</td>
                                                        <td>{{ $employees->dob }}</td>
                                                        <td>{{ $employees->status }}</td>
                                                        <td class="d-flex flex-column gap-1">
                                                            <a href="{{ route('employees.show', $employees->id) }}"
                                                                class="btn btn-sm btn-primary w-100">Details</a>
                                                            <a href="{{ route('employees.edit', $employees->id) }}"
                                                                class="btn btn-sm btn-info w-100">Edit</a>
                                                            {{-- <a href="{{ route('employees.connecteam.user', $employees->id) }}"
                                                                class="btn btn-sm btn-info w-100">Get data</a> --}}
                                                            
                                                            <form
                                                                action="{{ route('employees.destroy', encrypt($employees->id)) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger w-100"
                                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Left side columns -->
            </div>
        </section>

    </main><!-- End #main -->

@endsection
