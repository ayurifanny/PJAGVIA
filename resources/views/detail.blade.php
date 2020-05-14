@extends('layouts.app')

@section('navbar')
    @if (auth()->user()->hasRole('customer'))
      <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/home"><i class="fas fa-calendar mr-2"></i>Request Inspection</a>
      </li>
      <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
      </li>
    @elseif (auth()->user()->hasRole('inspector'))
      <li class="nav-item mb-3">
        <a class="nav-link" href="/home"><i class="fas fa-tachometer mr-2"></i>Dashboard</a>
      </li>
      <li class="nav-item mb-3">
        <a class="nav-link" href="/home"><i class="fas fa-list-ul mr-2"></i>List of Inspection Request</a>
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
                <div class="card-header"><h4>General Information</h4></div>
                <div class="card-body">
                  <strong><h2>{{$meeting_data->project_name}}</h2></strong>
                  <div class ="row">
                    <div class="col-sm-2">Client</div>
                    <div class="col">:  {{$meeting_data->customer_name}}</div>
                  </div>
                  <div class ="row">
                    <div class="col-sm-2 ">Inspector</div>
                    <div class="col ">:  {{$meeting_data->user->name}}</div>
                  </div>
                  <?php $dt = strtotime($meeting_data->meeting_date); ?>
                  <div class ="row">
                    <div class="col-sm-2 ">Date</div>
                    <div class="col ">: {{date('M d, Y', $dt)}}</div>
                  </div>
                  <div class ="row">
                    <div class="col-sm-2 ">Time</div>
                    <div class="col ">: {{date('H:i:s A', $dt)}}</div>
                  </div>
                  <br>
                  <div class ="row">
                    <div class="col-sm-2 ">Inspection Link</div>
                    <div class="col ">: <a href='{{$meeting_data->meeting_link}}' target="_blank" >{{$meeting_data->meeting_link}}</a></div>
                  </div>
                </div>
            </div>
            <div class="card mt-4">
              <div class="card-header"><h4>Uploaded Photo Information</h4></div>
              <div class="card-body">
                  
              </div>
            </div>
            <div class="card mt-4">
              <div class="card-header"><h4>Report<h4></div>
              <div class="card-body">
                  
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
