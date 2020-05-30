@section('styles')
<link href="{{ asset('css/canvas.css') }}" rel="stylesheet">
@endsection

<div class="container">

    <div class="row menu-canvas mx-1 my-2 py-3">
        <div class="col-md px-0">
            <h4 class="align-center"><strong>{{ $meeting_data[0]->project_name }} - Inspection Report</strong></h4>
        </div>

        <div class="ml-auto float-right pr-0">
            <img width="90" height="40" class="img-responsive d-inline-block align-center"
                src="http://www.pjagroup.com/wp-content/uploads/2019/06/PJA-logo.png" alt="">
        </div>
    </div>

    <div class="row pt-2">
        <div class="col-sm-2">Project Name</div>
        <div class="col ">:
            <span class="ml-2">{{ $meeting_data[0]->project_name }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">Inspection Date</div>
        <div class="col ">:
            <span class="ml-2">{{ $meeting_data[0]->meeting_date }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">Inspector Name</div>
        <div class="col ">:
            <span class="ml-2">{{ $report->inspector_name }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">Customer Name</div>
        <div class="col ">:
            <span class="ml-2">{{ $report->customer_name }}</span>
        </div>
    </div>

    <br>
    <div>
        <strong>APPROVED MATERIAL</strong>
        @if($upload_data_approved->count() > 0)
            <div class="table-responsive">
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
                                            <img src="{{'/storage/' . $pic->meeting_id . '/' . $pic->photo }}"
                                                class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                                        </td>
                                    @else
                                        <td>
                                            <img src="{{'/storage/' . $pic->meeting_id . '/' . $pic->photo_edited }}"
                                                class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                                        </td>
                                    @endif
                                    <td>{{ $pic->remarks }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-secondary">None</p>
        @endif
    </div>

    <br>
    <div>
        <strong>DECLINED MATERIAL</strong>

        @if($upload_data_declined->count() > 0)
            <div class="table-responsive">
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
                        @foreach($upload_data_declined as $key => $picd)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $picd->photo }}</td>
                                @if($picd->photo_edited == null)
                                    <td>
                                        <img max-width="307" max-height="240"
                                            src="{{'/storage/' . $picd->meeting_id . '/' . $picd->photo }}"
                                            class="img-fluid img-thumbnail" alt={{ $picd->photo }}>
                                    </td>
                                @else
                                    <td>
                                        <img max-width="307" max-height="240"
                                            src="{{'/storage/' . $picd->meeting_id . '/' . $picd->photo_edited }}"
                                            class="img-fluid img-thumbnail" alt={{ $picd->photo }}>
                                    </td>
                                @endif
                                <td>{{ $picd->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-secondary">None</p>
        @endif
    </div>

    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="ml-5 mr-auto float-left text-center">
                <p>Inspector</p>
                @if ($report->inspector_signature == null)
                <img width="90" height="40" class="img-responsive d-inline-block align-center"
                    src="#" alt="">
                @else
                <img width="90" height="40" class="img-responsive d-inline-block align-center"
                    src="{{ '/storage/sign/' . $report->host_id . '/sign-' . $report->id . '.png' }}" alt="host_sign">
                @endif
                <p class="pt-3"><u>{{ $report->inspector_name }}</u></p>
            </div>

            <div class="col">
            </div>

            <div class="mr-5 ml-auto float-right text-center">
                <p>Customer</p>
                @if ($report->customer_signature == null)
                <img width="90" height="40" class="img-responsive d-inline-block align-center"
                    src="#" alt="">
                @else
                <img width="90" height="40" class="img-responsive d-inline-block align-center"
                    src="{{'/storage/sign/' . $report->user_id . '/sign-' . $report->id . '.png'}}" alt="user_sign">
                @endif
                <p class="pt-3"><u>{{ $report->customer_name }}</u></p>
            </div>
        </div>
    </div>

</div>
