<style>
    .main {
        font-family: 'Open Sans';
        font-weight: 400;
        line-height: 1.6;
        color: #2c2c2c;
        text-align: left;
        box-sizing: border-box;
        font-size: 1em;
        border: 0.3px solid grey;
        margin: 20px 20px;
    }

    .title {
        border-bottom: 0.3px solid grey;
        font-size: 1.5em;
    }

    .align-center {
        display: flex;
        justify-content: center;
        align-items: center;
        /* padding: 10px !important; */
    }

    .logo {
        float: right;
        text-align: right;
        vertical-align: middle;
    }

    .general-info {
        border: 0.3px solid grey;
        margin-top: 200px !important;
    }

    .info {
        width: 100px;
    }

    .semicolon {
        width: 30px;
    }

    .no {
        width: 10%;
    }

    .prod-id {
        width: 20%;
    }

    .pic {
        width: 40%;
    }

    .remarks {
        width: 30%;
    }

</style>

<table class="main">
    <tr>
        <td class="title align-center">
            <strong>{{ $meeting_data[0]->project_name }} - Inspection Report</strong>
        </td>
        <td class="title logo">
            <img width="90" height="40" class="img-responsive d-inline-block align-center"
                src="http://www.pjagroup.com/wp-content/uploads/2019/06/PJA-logo.png" alt="">
        </td>
    </tr>
</table>

<table class="main general-info">
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="info">Project Name</td>
        <td class="semicolon">:</td>
        <td class="info-content">haha</td>
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
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <td><strong>APPROVED MATERIAL</strong></td>
    </tr>
</table>

<table class="main">
    @if($upload_data_approved->count() > 0)
        <tr>
            <th class="no">No</th>
            <th class="prod-id">Product ID</th>
            <th class="pic">Picture</th>
            <th class="remarks">Remarks</th>
        </tr>
        @foreach($upload_data_approved as $key => $pic)
            @if($pic->approved == 1)
                <tr>
                    <td class="no">{{ ++$key }}</td>
                    <td class="prod-id">{{ $pic->photo }}</td>
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
                    <td class="remarks">{{ $pic->remarks }}</td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td>None</td>
        </tr>
    @endif
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
<table class="main">
    @if($upload_data_declined->count() > 0)
        <tr>
            <th class="no">No</th>
            <th class="prod-id">Product ID</th>
            <th class="pic">Picture</th>
            <th class="remarks">Remarks</th>
        </tr>
        @foreach($upload_data_declined as $key => $pic)
            @if($pic->approved == 1)
                <tr>
                    <td class="no">{{ ++$key }}</td>
                    <td class="prod-id">{{ $pic->photo }}</td>
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
                    <td class="remarks">{{ $pic->remarks }}</td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td>None</td>
        </tr>
    @endif
</table>

<table>
    <tr>
        <td></td>
    </tr>
</table>

<table class="main">
    <tr class="sign-title">
        <td></td>
        <td class="inspector_sign">Inspector</td>
        <td></td>
        <td class="customer_sign">Client</td>
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
