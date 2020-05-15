@extends('layouts.app')

@section('navbar')
@if(auth()->user()->hasRole('customer'))
    <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/home"><i class="fas fa-calendar mr-2"></i>Request Inspection</a>
    </li>
    <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
    </li>
@elseif(auth()->user()->hasRole('inspector'))
    <li class="nav-item mb-3">
        <a class="nav-link" href="/home"><i class="fas fa-tachometer mr-2"></i>Dashboard</a>
    </li>
    <li php class="nav-item mb-3">
        <a class="nav-link" href="/list_request"><i class="fas fa-list-ul mr-2"></i>List of Inspection Request</a>
    </li>
    <li class="nav-item mb-3">
        <a class="nav-link" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
    </li>
@endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 py-3">
            <div class="card mt-4">
                <div class="card-header">
                    <p class="h2 text-center p-2"><strong>Request Inspection</strong></p>
                </div>
                <div class="card-body">
                    <table class="table">
                        <?php $key = 0; ?>
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Project Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Inspection Date</th>
                                <th scope="col">Inspection Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meeting_requests as $key => $meeting_request)
                                <tr>
                                    <td scope="row">{{ ++$key }}</td>
                                    <td>{{ $meeting_request->project_name }}</td>
                                    <td>{{ $meeting_request->customer_name }}</td>
                                    <?php $dt = strtotime($meeting_request->request_date); ?>
                                    <td>{{ date('M d, Y', $dt) }}</td>
                                    <td>{{ date('H:i:s A', $dt) }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ url('meetings/approve_meeting') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $meeting_request->id }}" />
                                            <button class="btn btn-success btn-submit">Approve</button>
                                        </form>
                                        {{-- <a href=# type="button" class="btn btn-danger">Decline</a></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
