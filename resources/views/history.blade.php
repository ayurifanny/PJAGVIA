@extends('layouts.app')

@section('navbar')
    @if (auth()->user()->hasRole('customer'))
      <li class="nav-item">
        <a class="nav-link" href="/home">Request Meeting</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="/history_meeting">History</a>
      </li>
    @elseif (auth()->user()->hasRole('inspector'))
      <li class="nav-item">
        <a class="nav-link" href="/home">List of Request Meeting</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="/history_meeting">History</a>
      </li>
    @endif
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
                            <th scope="col">Created At</th>
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
                            <td>{{$meeting_request->created_at}}</td>
                          </tr>

                          @endforeach
                        </tbody>
                    </table>
                        
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">History Meeting</div>
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
                            <th scope="col">Created At</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($meeting_history as $key => $meeting)
                          <tr>
                            <th scope="row">{{++$key}}</th>
                            <td>{{$meeting->project_name}}</td>
                            <td>{{$meeting->customer_name}}</td>
                            <?php $dt = strtotime($meeting->request_date); ?>
                            <td>{{date('M d, Y', $dt)}}</td>
                            <td>{{date('H:i:s A', $dt)}}</td>
                            <td>{{$meeting->created_at}}</td>
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
