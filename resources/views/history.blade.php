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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Request Inspection Meeting</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <?= $meeting_history ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
