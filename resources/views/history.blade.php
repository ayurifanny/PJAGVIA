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
        <a class="nav-link" href="/home"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
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
          @if (auth()->user()->hasRole('customer'))
            <div class="card mt-4">
              <div class="card-header"><p class="h3 p-1"><strong>Inspection Request</strong></p></div>
              
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Project Name</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Inspection Date</th>
                        <th scope="col">Inspection Time</th>
                        <th scope="col">Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($meeting_requests as $key => $meeting_request)
                        <tr>
                          <td>{{++$key}}</td>
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
            @endif
  
            <div class="card mt-4 pb-3">
              <div class="card-header"><p class="h3 p-1"><strong>Inspection History</strong></p></div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <?php $key = 0; ?>
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Project Name</th>
                        @if (auth()->user()->hasRole('inspector'))
                          <th scope="col">Customer Name</th>
                        @else   
                          <th scope="col">Inspector Name</th>
                        @endif
                        
                        <th scope="col">Inspection Date</th>
                        <th scope="col">Inspection Time</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Report</th>
                      </tr>
                    </thead>
    
                    <tbody>
                      @foreach($meeting_history as $key => $meeting)
                        <tr>
                          <td>{{++$key}}</td>
                          <td><a href='/meetings/detail/{{$meeting->id}}'>{{$meeting->project_name}} </a></td>
                          @if (auth()->user()->hasRole('inspector'))
                            <td>{{$meeting->customer_name}}</td>
                          @else   
                          <td>{{$meeting->user->name}}</td>
                          @endif
                          
                          <?php $dt = strtotime($meeting->meeting_date); ?>
                          <td>{{date('M d, Y', $dt)}}</td>
                          <td>{{date('H:i:s A', $dt)}}</td>
                          <td>{{$meeting->created_at}}</td>
                          @if ($meeting->meeting_date < Carbon\Carbon::now())
                          <td><a href='/report/{{$meeting->report_id}}'>View</a></td>
                          @else
                          <td>Not Available Yet</td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                
              </div>  
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
