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
        <div class="col-md-10 py-3">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>General Information</h4>
                </div>
                <div class="card-body">
                    <strong>
                        <h2>{{ $meeting_data->project_name }}</h2>
                    </strong>
                    <div class="row">
                        <div class="col-sm-2">Client</div>
                        <div class="col">: {{ $meeting_data->customer_name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 ">Inspector</div>
                        <div class="col ">: {{ $meeting_data->user->name }}</div>
                    </div>
                    <?php $dt = strtotime($meeting_data->meeting_date); ?>
                    <div class="row">
                        <div class="col-sm-2 ">Date</div>
                        <div class="col ">: {{ date('M d, Y', $dt) }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 ">Time</div>
                        <div class="col ">: {{ date('H:i:s A', $dt) }}</div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2 ">Inspection Link</div>
                        <div class="col ">: <a href='{{ $meeting_data->meeting_link }}'
                                target="_blank">{{ $meeting_data->meeting_link }}</a></div>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Uploaded Photo Information</h4>
                </div>
                
                <div class="card-body">
                    @if (auth()->user()->hasRole("inspector")):
                    <form method="POST" action="/upload" id="upload" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value={{ request()->route('id') }}>
                        <input type="file" name="file[]" multiple accept="image/*">
                        <input type="submit" value="Submit">
                    </form>
                    @endif

                    <table>
                        <tr>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>Picture</th>
                            <th>Remarks</th>
                            <th>Edited Picture</th>
                            <th>Action</th>
                        </tr>

                        @foreach($picture_data as $key => $pic)


                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>II-{{ str_pad($pic->meeting_id, 3, '0', STR_PAD_LEFT) }}-{{ str_pad($key, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td><img src='{{ url("storage/" . $pic->meeting_id . "/" . $pic->photo) }}'
                                        alt={{ $pic->photo }}></td>
                                <td>{{ $pic->remarks }}</td>



                                @if($pic->photo_edited == null):
                                    <td></td>
                                @else
                                    <td><img src='{{ url("storage/" . $pic->meeting_id . "/" . $pic->photo_edited) }}'
                                            alt={{ $pic->photo }}></td>
                                @endif

                                <td>
                                    @if($pic->approved == -1):
                                        @if(auth()->user()->hasRole('inspector')):
                                            Not Reviewed Yet
                                        @else
                                        <button type="button"
                                        onclick="window.location='{{ url("photo_detail/" . $pic->id) }}'">{{ $pic->photo }}</button>
                                        @endif
                                        
                                    @elseif($pic->approved == 0):
                                        label decline
                                    @elseif($pic->approved == 1):
                                        label approve
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Report<h4>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
