@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />
@endsection

@section('navbar')
@if(auth()->user()->hasRole('customer'))
    <li class="nav-item">
        <a class="nav-link" href="/home">Request Meeting</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/history_meeting">History</a>
    </li>
@elseif(auth()->user()->hasRole('inspector'))
    <li class="nav-item">
        <a class="nav-link" href="/home">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/list_request">List of Request Meeting</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/history_meeting">History</a>
    </li>
@endif
@endsection

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Dashboard</h2>
        </div>
        <div class="panel-body">
            {!! $calendar->calendar() !!}
        </div>
    </div>
</div>
@endsection

@section('additional_script')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
{!! $calendar->script() !!}
@endsection
