@extends('Layouts.userLayout')
@section('pageName', 'Dashboard | Payouts')

@section('content')

    <main id="main" class="main">
        @include('User.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Rejected Payouts</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body pt-3 table-responsive">
                            <div class="my-3">
                                <span class="card-title">Rejected Payouts</span>
                            </div>
                            <table class="table table-borderless datatable">
                                <thead>
                                 <tr>
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">#No</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button class="datatable-sorter">Referrer</button></th> --}}
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Approved By</button></th>
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Amount</button></th>
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Status</button></th>
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Created at</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button class="datatable-sorter">Action</button></th> --}}
                                    </tr>
                                </thead>

                                <tbody>

                                    @if ($payouts)
                                        @foreach ($payouts as $payout)
                                            <tr class="text-start">
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- <td>{{ $payout->referrer_id }}</td> --}}
                                                <td>{{ $payout->approver_name ?? 'N/A' }}</td>
                                                <td>{{ $payout->total_amount }}</td>
                                                <td>{{ $payout->status }}</td>
                                                <td>{{ $payout->created_at }}</td>
                                                {{-- <td>
                                                    <form action="{{ route('payout.delete',encrypt($payout->id)) }}" method="POST" class="d-inline-block w-100">
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
