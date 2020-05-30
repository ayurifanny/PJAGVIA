<?php

namespace App\Http\Controllers;

use App\Meetings;
use App\Reports;
use App\Uploads;
use App\User;
use Illuminate\Http\Request;
use PDF;
use Storage;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $report = Reports::findOrFail($id);
        if ($report->inspector_name == null) {
            $report->inspector_name = User::select('name')->where('id', $report->host_id)->first()['name'];
        }

        if ($report->customer_name == null) {
            $report->customer_name = User::select('name')->where('id', $report->user_id)->first()['name'];
        }

        $meeting_data = Meetings::where('report_id', $id)->get();
        $upload_data_approved = Uploads::select("id", "meeting_id", "photo", "photo_edited", "remarks", "approved")->where('meeting_id', $meeting_data[0]->id)->where('approved', 1)->get();
        $upload_data_declined = Uploads::select("id", "meeting_id", "photo", "photo_edited", "remarks", "approved")->where('meeting_id', $meeting_data[0]->id)->where('approved', 0)->get();
        return \View::make('report')
            ->with(compact('meeting_data'))
            ->with(compact('upload_data_approved'))
            ->with(compact('upload_data_declined'))
            ->with(compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }

    public function download_pdf($id)
    {
        ini_set('max_execution_time', 300);
        $report = Reports::findOrFail($id);
        if ($report->inspector_name == null) {
            $report->inspector_name = User::select('name')->where('id', $report->host_id)->first()['name'];
        }

        if ($report->customer_name == null) {
            $report->customer_name = User::select('name')->where('id', $report->user_id)->first()['name'];
        }
        $meeting_data = Meetings::where('report_id', $id)->get();
        $upload_data_approved = Uploads::select("id", "meeting_id", "photo", "photo_edited", "remarks", "approved")->where('meeting_id', $meeting_data[0]->id)->where('approved', 1)->get();
        $upload_data_declined = Uploads::select("id", "meeting_id", "photo", "photo_edited", "remarks", "approved")->where('meeting_id', $meeting_data[0]->id)->where('approved', 0)->get();

        // $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf2', ['meeting_data' => $meeting_data, 'upload_data_declined' => $upload_data_declined, 'upload_data_approved' => $upload_data_approved, 'report' => $report]);

        // return $pdf->render('Report-' . '.pdf');
        $html_content = \View::make('pdf')
            ->with(compact('meeting_data'))
            ->with(compact('upload_data_approved'))
            ->with(compact('upload_data_declined'))
            ->with(compact('report'));
        PDF::SetTitle('Hello World');
        PDF::AddPage();

        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::Output('hello_world.pdf');
    }

    public function save_sign(Request $request)
    {
        $report = Reports::findOrFail($request['id']);
        $role = $request['role'];

        if ($role == 'inspector') {
            $user = $report->host_id;
        } else {
            $user = $report->user_id;
        }

        $img = $request['hidden_data'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $filename = 'sign-' . $request['id'] . '.png';

        Storage::disk('public')->put('sign/' . $user . '/' . $filename, $data);

        if ($role == 'inspector') {
            $report->inspector_signature = $filename;
        } else {
            $report->customer_signature = $filename;
        }
        $report->save();
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'success'));
        exit;
    }
}
