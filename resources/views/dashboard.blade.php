@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection

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
        <a class="nav-link" href="/list_request"><i class="fas fa-list-ul mr-2"></i>List of Inspection Request</a>
      </li>
      <li class="nav-item mb-3">
        <a class="nav-link" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
      </li>
    @endif
@endsection

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body" >
           {!! $calendar->calendar() !!}
       </div>
   </div>
</div>
@endsection

@section('additional_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
{!! $calendar->script() !!}
@endsection
