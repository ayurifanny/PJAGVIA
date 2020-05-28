@section('styles')
<link href="{{ asset('css/canvas.css') }}" rel="stylesheet">
@endsection

<div class="container">
    
        <div class="row menu-canvas mx-1 my-2 py-3">
            <div class="col-md px-0">
                <h4><strong>{{$meeting_data[0]->project_name}} Inspection Report</strong></h4>
            </div> 

            <div class="ml-auto float-right pr-0">
                <img width="90" height="40" class="d-inline-block align-center"  src = "http://www.pjagroup.com/wp-content/uploads/2019/06/PJA-logo.png" alt="">
            </div>
        </div>

        <div class="row pt-2">
            <div class="col-sm-2">Project Name</div>
            <div class="col ">: 
                <span class="ml-2">{{$meeting_data[0]->project_name}}</span>
            </div>    
        </div>

        <div class="row">
            <div class="col-sm-2">Inspection Date</div>
            <div class="col ">: 
                <span class="ml-2">{{$meeting_data[0]->meeting_date}}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">Inspector Name</div>
            <div class="col ">: 
                <span class="ml-2">INSPECTOR NAME</span>
            </div>    
        </div>

        <div class="row">
            <div class="col-sm-2">Customer Name</div>
            <div class="col ">: 
                <span class="ml-2">{{$meeting_data[0]->customer_name}}</span>
            </div>
        </div>

        <br>
        <div>
            <strong>APPROVED MATERIAL</strong>
            
                @if($upload_data_declined != null)  
                <table class="table table-bordered px-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>Picture</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($upload_data_approved as $key => $pic)
                        @if($pic->approved == 1)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $pic->photo }}</td>
                                @if($pic->photo_edited == null)
                                    <td>
                                        <img src='{{ url("storage/" . $pic->meeting_id . "/" . $pic->photo) }}'
                                        class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                                    </td>
                                @else
                                    <td>
                                        <img src='{{ url("storage/" . $pic->meeting_id . "/" . $pic->photo_edited) }}' 
                                        class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                                    </td>
                                @endif
                                <td>{{ $pic->remarks }}</td>                          
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                @endif
        </div>

        <br>
        <div>
            <strong>DECLINED MATERIAL</strong> 
            
                @if(!empty($upload_data_declined))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product ID</th>
                                <th>Picture</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($upload_data_declined as $key => $picd)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $picd->photo }}</td>
                                @if($picd->photo_edited == null)
                                    <td>
                                        <img max-width="307" max-height="240" src='{{ url("storage/" . $picd->meeting_id . "/" . $picd->photo) }}'
                                        class="img-fluid img-thumbnail" alt={{ $picd->photo }}>
                                    </td>
                                @else
                                    <td>
                                        <img max-width="307" max-height="240" src='{{ url("storage/" . $picd->meeting_id . "/" . $picd->photo_edited) }}' 
                                        class="img-fluid img-thumbnail" alt={{ $picd->photo }}>
                                    </td>
                                @endif
                                <td>{{ $picd->remarks }}</td>                          
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
        </div>

        <br>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="ml-5 mr-auto float-left">
                    <p class="text-center">Inspector</p>
                    <img width="90" height="40" class="d-inline-block align-center"  src = "http://www.pjagroup.com/wp-content/uploads/2019/06/PJA-logo.png" alt="">
                    <p class="text-center pt-3"><u>INSPECTOR NAME</u></p>
                </div>

                <div class="col">
                </div>

                <div class="mr-5 ml-auto float-right">
                    <p class="text-center">Customer</p>
                    <img width="90" height="40" class="d-inline-block align-center"  src = "http://www.pjagroup.com/wp-content/uploads/2019/06/PJA-logo.png" alt="">
                    <p class="text-center pt-3"><u>{{$meeting_data[0]->customer_name}}</u></p>
                </div>
            </div>
        </div>
    
</div>