<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MeetingRequests;
use App\Meetings;

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
        if (auth()->user()->hasRole('customer')) {
            return view('request_meeting');
        }
        else if (auth()->user()->hasRole('inspector')) {
            $meeting_requests =  MeetingRequests::where('approved', 0)->latest()->get();
            return view('list_of_requests', compact('meeting_requests'));
        }
        
    }


    public function history_meeting()
    {
        if (auth()->user()->hasRole('customer'))
            $meeting_requests =  MeetingRequests::where('user_id', $id_user)->where('approved', 0)->latest()->get();
        $meeting_history =  Meetings::where('user_id', \Auth::id())->orderBy('meeting_date', 'DESC')->get();        
        return \View::make('history')
            ->with(compact('meeting_requests'))
            ->with(compact('meeting_history'));
    }


    public function request_meeting(Request $request) {
        if (auth()->user()->hasRole('customer')) {
            $request->validate([
                'name' => 'required',
                'project_name' => 'required',
                'datepicker' => 'required',
                'time' => 'required'
            ], [
                'name.required' => 'Name is required',
                'project_name.required' => 'Project Name is required',
                'datepicker.required' => 'Request Date is required',
                'time.required' => 'Request Time is required'
            ]);
            
            
            $input = $request->all();
            $req_meeting = new MeetingRequests();
            $req_meeting->customer_name = $input['name'];
            $req_meeting->project_name = $input['project_name'];
            $request_date = $input['datepicker'];
            $request_time = $input['time'];
            $combinedDT = date('Y-m-d H:i:s', strtotime("$request_date $request_time"));
            $req_meeting->request_date = $combinedDT;
            $req_meeting->approved = 0;
            $req_meeting->save();
    
            return back()->with('success',  'Request Meeting has been saved');
        }
        else {
            return back()->with('error',  'Not Authorized');
        }
    }

    public function approve_meeting(Request $request) {
        if (auth()->user()->hasRole('inspector')) {
            $input = $request->all();
            $meeting_request = MeetingRequests::findOrFail($input['id']);
            

            $meeting = new Meetings();
            $meeting->user_id = $meeting_request->user_id;
            $meeting->customer_name = $meeting_request->customer_name;
            $meeting->project_name = $meeting_request->project_name;
            $meeting->meeting_date = $meeting_request->meeting_date;
            $meeting->host_id = \Auth::id();
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $meeting->meeting_link = $_ENV['JITSI_LINK'] .'/' . substr(str_shuffle($permitted_chars), 0, 10);
            $meeting->approved_date = now();
            $meeting->save();

            $meeting_request->approved = 1;
            $meeting_request->save();
            return back()->with('success',  'Request Meeting has been saved');

        }
    }


}
