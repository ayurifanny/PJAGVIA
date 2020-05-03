<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MeetingRequests;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('customer_home');
    }

    public function request_meeting(Request $request) {
        $request->validate([
            'name' => 'required',
            'project-name' => 'required',
            'datepicker' => 'required',
            'time' => 'required'
        ], [
            'name.required' => 'Name is required',
            'project-name.required' => 'Password is required',
            'datepicker.required' => 'Request Date is required',
            'time.required' => 'Time is required'
        ]);
        
        
        $input = $request->all();
        $req_meeting = new MeetingRequests();
        $req_meeting->customer_name = $input['name'];
        $req_meeting->project_name = $input['project-name'];
        $request_date = $input['datepicker'];
        $request_time = $input['time'];
        $combinedDT = date('Y-m-d H:i:s', strtotime("$request_date $request_time"));
        $req_meeting->request_date = $combinedDT;
        $req_meeting->approved = 0;
        $req_meeting->save();

        return back()->with('success',  'Request Meeting has been saved'); 
    }
}
