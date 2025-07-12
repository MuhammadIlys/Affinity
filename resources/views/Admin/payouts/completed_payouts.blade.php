@extends('Layouts.adminlayout')
@section('pageName', 'Dashboard | Admin')

@section('content')

    <main id="main" class="main">
        @include('User.includes.alerts')
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Completed Payouts</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body pt-3 table-responsive">
                            <div class="my-3">
                                <span class="card-title">Completed Payouts</span>
                            </div>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">#No</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button class="datatable-sorter">Referrer</button></th> --}}
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Referrer</button></th>
                                        {{-- <th scope="col" data-sortable="true"><button class="datatable-sorter">Approved By</button></th> --}}
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Amount</button></th>
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Status</button></th>
                                        <th scope="col" data-sortable="true"><button class="datatable-sorter">Created
                                                at</button></th>
                                        <th scope="col" data-sortable="true"><button
                                                class="datatable-sorter">Action</button></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @if ($payouts)
                                        @foreach ($payouts as $payout)
                                            <tr class="text-start">
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- <td>{{ $payout->referrer_id }}</td> --}}
                                                <td>{{ $payout->referrer_name ?? 'Nill' }}</td>
                                                <td>{{ $payout->total_amount }}</td>
                                                <td>{{ $payout->status }}</td>
                                                <td>{{ $payout->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('request.pending', encrypt($payout->id)) }}"
                                                        class="btn btn-sm btn-info mb-1"
                                                        onclick="return confirm('Are you sure you want to mark this request as Pending?')">
                                                        Pending
                                                    </a>

                                                    {{-- <a href="javascript:void(0)"
                                                        class="btn btn-sm btn-primary mb-1 edit-btn"
                                                        data-id="{{ $payout->id }}"
                                                        data-amount="{{ $payout->total_amount }}"
                                                        data-url="{{ route('request.update', encrypt($payout->id)) }}">
                                                        Edit
                                                    </a>  --}}
                                                    <a href="{{ route('request.reject', encrypt($payout->id)) }}"
                                                        class="btn btn-sm btn-warning mb-1"
                                                        onclick="return confirm('Are you sure you want to Reject this request?')">
                                                        Reject
                                                    </a>
                                                    <form action="{{ route('request.delete', encrypt($payout->id)) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this request?')">Delete</button>
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
        </section>

    </main><!-- End #main -->

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount</label>
                            <input type="number" name="total_amount" id="totalAmount" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
