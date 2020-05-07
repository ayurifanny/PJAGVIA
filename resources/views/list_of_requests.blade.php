@extends('layouts.app')

@section('navbar')
    <li class="nav-item">
      <a class="nav-link" href="/home">Dashboard</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="/list_request">List of Request Meeting</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/history_meeting">History</a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
                <div class="card mt-4">
                    <div class="card-header">Request Meeting</div>
                    <div class="card-body">
                      <table class="table">
                        <?php $key = 0; ?>
                        <thead>
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Project Name</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Meeting Date</th>
                            <th scope="col">Meeting Time</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($meeting_requests as $key => $meeting_request)
                          <tr>
                            <th scope="row">{{++$key}}</th>
                            <td>{{$meeting_request->project_name}}</td>
                            <td>{{$meeting_request->customer_name}}</td>
                            <?php $dt = strtotime($meeting_request->request_date); ?>
                            <td>{{date('M d, Y', $dt)}}</td>
                            <td>{{date('H:i:s A', $dt)}}</td>
                            <td><form method="POST" action="{{ url('meetings/approve_meeting') }}">
                              {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$meeting_request->id}}" />
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
@endsection
