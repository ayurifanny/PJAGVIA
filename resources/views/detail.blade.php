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
                    <div class="card-header">General Information</div>
                    <div class="card-body">
                        
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
