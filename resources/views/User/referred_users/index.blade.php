@extends('Layouts.userLayout')
@section('pageName', 'Dashboard | User')

@section('content')

    <main id="main" class="main">
        @include('User.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Referred Users</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body pt-3 table-responsive">
                            <div class="my-3">
                                <span class="card-title">Referred Users</span>
                            </div>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">#No</button></th>
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">First
                                                Name</button></th>
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Last
                                                Name</button></th>
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Referred
                                                By</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Email</button></th> --}}
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Job
                                                Title</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Address</button></th> --}}
                                        {{-- <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Phone</button></th> --}}
                                        {{-- <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Balance</button></th> --}}
                                        {{-- <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">DOB</button></th> --}}
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Status</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Action</button></th> --}}
                                    </tr>
                                </thead>

                                <tbody>

                                    @if ($referred_users)
                                        @foreach ($referred_users as $referred_user)
                                            <tr class="text-start">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $referred_user->first_name }}</td>
                                                <td>{{ $referred_user->last_name }}</td>
                                                <td>{{ @$referred_user->referrer->first_name . ' ' . @$referred_user->referrer->last_name }}
                                                </td>
                                                {{-- <td>{{ $referred_user->email }}</td> --}}
                                                <td>{{ $referred_user->job_title }}</td>
                                                {{-- <td>{{ $referred_user->phone }}</td> --}}
                                                {{-- <td>{{ $referred_user->total_amount }}</td> --}}
                                                <td>{{ $referred_user->status }}</td>
                                                {{-- <td>{{ $referred_user->address }}</td> --}}
                                                {{-- <td>{{ $referred_user->dob }}</td> --}}
                                                {{-- <td class="d-flex flex-column gap-1">
                                                    <a href="{{  }}" class="btn btn-sm btn-info w-100">Edit</a>
                                                    <form action="" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger w-100"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->

@endsection
