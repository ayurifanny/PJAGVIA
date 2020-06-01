<style>

    .title {
        
        font-size: 1.5em;
        float: left;
        width: 75%;
    }
    .border {
        border-bottom: 0.3px solid grey;
    }

    .align-center {
        display: flex;
        justify-content: center !important;
        align-items: center;
    }

    .logo {
        float: right;
        text-align: right;
        vertical-align: middle;
        width: 25%;
        
    }

    .info-content {
        width: fit-content;
    }
    .general-info {
        color: #2c2c2c;
        border: 0.3px solid grey;
    }

    .info {
        width: 100px;
    }

    .semicolon {
        width: 30px;
    }

    th, td {
        vertical-align : center;
    }

    .table-content{
        color: #2c2c2c;
        padding-top : 3px;
        margin-right : 2px;
        margin-top: 2px;
        margin-bottom : 2px;
        padding-left: 0px;
    }

    .no {
        vertical-align : middle;
        text-align: center;
        border: 1px solid #6c757d;
        border-radius: 0.25rem;
        width: 5%;
    }

    .prod-id {
        border: 1px solid #6c757d;
        border-radius: 0.25rem;
        vertical-align : middle;
        text-align: center;
        width: 25%;
    }

    .pic {
        border: 1px solid #6c757d;
        border-radius: 0.25rem;
        vertical-align : middle;
        text-align: center;
        justify-content: center;
        align-items: center;
        width: 40%;
        padding-top: 5px !important;
    }

    .remarks {
        border: 1px solid #6c757d;
        border-radius: 0.25rem;
        vertical-align: middle !important;
        text-align: center;
        width: 30%;
    }

    .sign-title{
        text-align : center;
    }

    .sign-name{
        text-align : center;
    }

    .noborder{
        border : none;
    }

</style>

<table class="noborder">
    <tr>
        <td class="title"><strong>{{$meeting_data[0]->project_name}} - Inspection Report</strong></td>
        <td class="logo">
            <img width="70" height="40" class="img-responsive d-inline-block align-center"
                src="/storage/logo.png" alt="">
        </td>
    </tr>
    <tr>
        <td class="border"></td>
        <td class="border"></td>
    </tr>
</table>

<table class="general-info noborder">
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="info">Project Name</td>
        <td class="semicolon">:</td>
        <td class="info-content">{{ $meeting_data[0]->project_name }}</td>
    </tr>
    <tr>
        <td class="info">Inspection Date</td>
        <td class="semicolon">:</td>
        <?php $dt = strtotime($meeting_data[0]->meeting_date); ?>
                                            
        <td class="info-content">{{ date('M d, Y H:i:s', $dt) }}</td>
    </tr>
    <tr>
        <td class="info">Client Name</td>
        <td class="semicolon">:</td>
        <td class="info-content">{{ $report->customer_name }}</td>
    </tr>
    <tr>
        <td class="info">Inspector Name</td>
        <td class="semicolon">:</td>
        <td class="info-content">{{ $report->inspector_name }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <td><strong>APPROVED MATERIAL</strong></td>
    </tr>
</table>


@if($upload_data_approved->count() > 0)
    <table class="table-content align-center">
        <tr>
            <th class="no"><strong> No</strong></th>
            <th class="prod-id"><strong>Product ID</strong></th>
            <th class="pic"><strong>Picture</strong></th>
            <th class="remarks"><strong>Remarks</strong></th>
        </tr>
        @foreach($upload_data_approved as $key => $pic)
            @if($pic->approved == 1)
                <tr>
                    <td class="no">{{ ++$key }}</td>
                    <td class="prod-id"> {{ $pic->photo }}</td>
                    @if($pic->photo_edited == null)
                        <td class="pic">
                            <img src="{{ '/storage/' . $pic->meeting_id . '/' . $pic->photo }}"
                                class="img-fluid img-thumbnail img-upload" alt={{ $pic->photo }}>
                        </td>
                    @else
                        <td class="pic">
                            <img src="{{ '/storage/' . $pic->meeting_id . '/' . $pic->photo_edited }}"
                                class="img-fluid img-thumbnail img-upload" alt={{ $pic->photo }}>
                        </td>
                    @endif
                    <td class="remarks">{{ $pic->remarks }}</td>
                </tr>
            @endif
        @endforeach
    </table>
@else
    <table class="noborder">
        <tr>
            <td>None</td>
        </tr>
    </table>
@endif


<table>
    <tr>
        <td></td>
    </tr>
</table>


<table>
    <tr>
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <td><strong>DECLINED MATERIAL</strong></td>
    </tr>
</table>

@if($upload_data_declined->count() > 0)
    <table class="table-content align-center">
        <tr>
            <th class="no">No </th>
            <th class="prod-id">Product ID</th>
            <th class="pic">Picture</th>
            <th class="remarks">Remarks</th>
        </tr>
        @foreach($upload_data_declined as $key => $pic)
            @if($pic->approved == 0)
                <tr>
                    <td class="no">{{ ++$key }}</td>
                    <td class="prod-id"> {{ $pic->photo }}</td>
                    @if($pic->photo_edited == null)
                        <td class="pic">
                            <img src="{{ '/storage/' . $pic->meeting_id . '/' . $pic->photo }}"
                                class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                        </td>
                    @else
                        <td class="pic">
                            <img src="{{ '/storage/' . $pic->meeting_id . '/' . $pic->photo_edited }}"
                                class="img-fluid img-thumbnail" alt={{ $pic->photo }}>
                        </td>
                    @endif
                    <td class="remarks align-center">{{ $pic->remarks }}</td>
                </tr>
            @endif
        @endforeach
    </table>
@else
    <table class="main noborder">
        <tr>
            <td>None</td>
        </tr>
    </table>
@endif


<table>
    <tr>
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <td></td>
    </tr>
</table>

<table class="main noborder">
    <tr class="sign-title">
        <td></td>
        <td class="inspector_sign"><strong>Inspector</strong></td>
        <td></td>
        <td class="customer_sign"><strong>Client</strong></td>
        <td></td>
    </tr>
    <tr class="sign">
        <td></td>
        <td class="inspector_sign">
            @if($report->inspector_signature == null)
                <img width="90" height="40" class="img-responsive d-inline-block align-center" src="#" alt="">
            @else
                <img width="90" height="40" class="img-responsive d-inline-block align-center"
                    src="{{ '/storage/sign/' . $report->host_id . '/sign-' . $report->id . '.png' }}"
                    alt="host_sign">
            @endif
        </td>
        <td></td>
        <td class="customer_sign">
            @if($report->customer_signature == null)
                <img width="90" height="40" class="img-responsive d-inline-block align-center" src="#" alt="">
            @else
                <img width="90" height="40" class="img-responsive d-inline-block align-center"
                    src="{{ '/storage/sign/' . $report->user_id . '/sign-' . $report->id . '.png' }}"
                    alt="user_sign">
            @endif
        </td>
        <td></td>
    </tr>
    <tr class="sign-name">
        <td></td>
        <td class="inspector_sign"><u>{{ $report->inspector_name }}</u></td>
        <td></td>
        <td class="customer_sign"><u>{{ $report->customer_name }}</u></td>
        <td></td>
    </tr>
</table>
