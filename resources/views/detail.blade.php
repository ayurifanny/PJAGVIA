@extends('layouts.app')

@section('navbar')
@if(auth()->user()->hasRole('customer'))
    <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/home"><i class="fas fa-calendar mr-2"></i>Request Inspection</a>
    </li>
    <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
    </li>
@elseif(auth()->user()->hasRole('inspector'))
    <li class="nav-item mb-3">
        <a class="nav-link" href="/home"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
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
        <div class="col-md-12 py-3">
            <div class="card mt-4">
                <div class="card-header">
                    <h3><strong>General Information</strong></h3>
                </div>
                <div class="card-body">
                    <strong>
                        <h2>{{ $meeting_data->project_name }}</h2>
                    </strong>
                    <div class="row">
                        <div class="col-sm-3">Client</div>
                        <div class="col">: {{ $meeting_data->customer_name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">Inspector</div>
                        <div class="col ">: {{ $meeting_data->user->name }}</div>
                    </div>
                    <?php $dt = strtotime($meeting_data->meeting_date); ?>
                    <div class="row">
                        <div class="col-sm-3 ">Date</div>
                        <div class="col ">: {{ date('M d, Y', $dt) }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">Time</div>
                        <div class="col ">: {{ date('H:i:s A', $dt) }}</div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3 ">Inspection Link</div>
                        <div class="col ">: <a href='{{ $meeting_data->meeting_link }}'
                                target="_blank">{{ $meeting_data->meeting_link }}</a></div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3><strong>Uploaded Photo Information</strong></h3>
                </div>
                
                <div class="card-body">
                    @if (auth()->user()->hasRole("inspector"))
                    <form method="POST" action="/upload" id="upload" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="border border-custom mx-1 mb-3 p-1">
                            <div class="input-group my-3">
                                <input type="hidden" name="id" value={{ request()->route('id') }}>
                                
                                <label class="col-form-label text-md-right ml-3">
                                    Add Picture(s) :
                                </label>
                                
                                <div class="col">
                                    <span class="btn btn-default btn-file">
                                        <input id="file" name="file[]" type="file" class="file m5-5" multiple accept="image/*" data-show-upload="true" data-show-caption="true">
                                    </span>
                                </div>
                                
                                <div class="float-right mr-3">
                                    <button class="btn btn-success" type="submit">Upload</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @endif
                    <table class="table table-responsive" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product ID</th>
                                <th>Picture</th>
                                <th>Remarks</th>
                                <th>Edited Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($picture_data as $key => $pic)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $pic->photo }}</td>
                                    <td>
                                        <img src='{{ url("storage/" . $pic->meeting_id . "/" . $pic->photo) }}'
                                    class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                                    </td>
                                    <td>{{ $pic->remarks }}</td>

                                    @if($pic->photo_edited == null)
                                        <td></td>
                                    @else
                                        <td>
                                            <img src='{{ url("storage/" . $pic->meeting_id . "/" . $pic->photo_edited) }}' 
                                            class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                                        </td>
                                    @endif

                                    <td>
                                        @if($pic->approved == -1)
                                            @if(auth()->user()->hasRole('inspector'))
                                                <button type="button" class="btn btn-primary mb-3" data-toggle="tooltip" data-placement="bottom" title="Detail Picture"
                                                    onclick="window.location='{{ url("photo_detail/" . $pic->id) }}'">In Review
                                                </button>
                                                <span> <form action="/photo/{{$pic->id}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </span>
                                            @else
                                                <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    onclick="window.location='{{ url("photo_detail/" . $pic->id) }}'">
                                                    <i class='fas fa-edit'></i>
                                                </button>
                                            @endif
                                        @elseif($pic->approved == 0)
                                            <span class="label label-danger p-2 text-white">Declined</span>
                                        @elseif($pic->approved == 1)
                                            <span class="label label-success p-2 text-white">Approved</span>
                                        @endif
                                    </td>                                    
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