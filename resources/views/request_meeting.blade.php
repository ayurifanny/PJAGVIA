@extends('layouts.app')

@section('navbar')
    @if (auth()->user()->hasRole('customer'))
      <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/home"><i class="fas fa-calendar mr-2"></i>Request Inspection</a>
      </li>
      <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
      </li>
    @endif
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 py-5">
            <div class="card">
                <div class="card-header"><p class="h2 text-center p-2"><strong>Request Inspection</strong></p></div>
                <div class="card-body">
                    @if (\Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {!! \Session::get('success') !!}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('meetings/request_meeting') }}">
  
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label>Customer Name:</label>
                            <input type="text" name="name" class="form-control" id="customer_name" placeholder="John">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
               
                        <div class="form-group">
                            <label>Project Name:</label>
                            <input type="text" name="project_name" class="form-control" placeholder="Project Name">
                            @if ($errors->has('project_name'))
                                <span class="text-danger">{{ $errors->first('project_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Request Inspection Date:</label>
                            <div class='input-group date' id='datepicker'>
                                <input type='text' class="form-control datepicker"  name="datepicker" placeholder="mm/dd/yyyy"/>
                            </div>
                            @if ($errors->has('datepicker'))
                                <span class="text-danger">{{ $errors->first('datepicker') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-5">
                            <label for="">Request Inspection Time:</label>
                            <div class='input-group date' id='timepicker' name="time">
                                {!! Form::time('time', null, ['class' => 'form-control']) !!}
                            </div>
                            @if ($errors->has('time'))
                                <span class="text-danger">{{ $errors->first('time') }}</span>
                            @endif
                        </div>
                    
               
                        <div class="form-group">
                            <button class="btn btn-primary btn-submit btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_script')
<script>
    $('.datepicker').datepicker({
        minDate:3
    });

    $(document).ready(function ()
    {
        var name = '<?=auth()->user()->name?>'
        $("#customer_name").val(name);
    });
</script>
@endsection