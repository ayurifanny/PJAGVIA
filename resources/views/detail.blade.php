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
                    <div class="card-header">General Information //rapiin ya titik duanya lurusin</div>
                    <div class="card-body">
                      <strong><h2>{{$meeting_data->project_name}}</h2></strong>
                      <h6>Client: {{$meeting_data->customer_name}}</h6>
                      <h6>Inspector: {{$meeting_data->user->name}}</h6>
                      <?php $dt = strtotime($meeting_data->meeting_date); ?>
                      <h6>Date: {{date('M d, Y', $dt)}}</h6>
                      <h6>Time: {{date('H:i:s A', $dt)}}</h6>
                      <br>
                      <h6>Meeting Link: <a href='{{$meeting_data->meeting_link}}' target="_blank" >{{$meeting_data->meeting_link}}</a></h6>
                    </div>
                </div>
                <div class="card mt-4">
                  <div class="card-header">Uploaded Photo Information</div>
                  <div class="card-body">
                      
                  </div>
              </div>
              <div class="card mt-4">
                <div class="card-header">Report</div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
