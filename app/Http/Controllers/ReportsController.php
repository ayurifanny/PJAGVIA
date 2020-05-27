<?php

namespace App\Http\Controllers;

use App\Meetings;
use App\Reports;
use App\Uploads;
use Illuminate\Http\Request;
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
        return view('report');
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
        $meeting_data = Meetings::findOrFail($id);
        $picture_data = Uploads::where('meeting_id', $id)->get();

        $pdf = PDF::loadView('pdf', ['meeting_data' => $meeting_data, 'picture_data' => $picture_data]);

        return $pdf->download('itsolutionstuff.pdf');
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
