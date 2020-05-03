@extends('layouts.app')

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

                    <form method="POST" action="{{ url('meetings/request_meeting') }}">
  
                        {{ csrf_field() }}
              
                        <div class="form-group">
                            <label>Customer Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="John">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
               
                        <div class="form-group">
                            <label>Project Name:</label>
                            <input type="text" name="project-name" class="form-control" placeholder="Project Name">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Request Date:</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control datepicker" placeholder="dd/mm/yyyy"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Time:</label>
                            <div class='input-group date' id='datetimepicker1'>
                                {!! Form::time('timee', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    
               
                        <div class="form-group">
                            <button class="btn btn-success btn-submit">Submit</button>
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
</script>
@endsection