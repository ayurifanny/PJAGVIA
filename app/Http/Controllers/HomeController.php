<?php

namespace App\Http\Controllers;

use App\Event;
use App\MeetingRequests;
use App\Meetings;
use App\Reports;
use Calendar;
use Illuminate\Http\Request;

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
        } else if (auth()->user()->hasRole('inspector')) {
            return $this->show_calendar();
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function show_calendar()
    {
        if (auth()->user()->hasRole('inspector')) {
            $events = [];
            $data = Event::where('user_id', \Auth::id())->get();
            if ($data->count()) {
                foreach ($data as $key => $value) {
                    $events[] = Calendar::event(
                        $value->title,
                        false,
                        new \DateTime($value->start),
                        new \DateTime($value->end),
                        null,
                        // Add color
                        [
                            'color' => '#000080',
                            'textColor' => '#FFFFFF',
                            'backgroundColor' => '#f8f9f9',
                            'borderColor' => '#f8f9f9',
                            'url' => '/meetings/detail/' . $value->meeting_id,
                        ]
                    );
                }
            }
            $calendar = Calendar::addEvents($events);

            return view('dashboard', compact('calendar'));
        } else {
            abort(403, 'Unauthorized action.');
        }

    }

    public function list_request()
    {
        $meeting_requests = MeetingRequests::where('approved', 0)->latest()->get();
        return view('list_of_requests', compact('meeting_requests'));
    }

    public function history_meeting()
    {
        if (auth()->user()->hasRole('customer')) {
            $meeting_requests = MeetingRequests::where('user_id', \Auth::id())->where('approved', 0)->latest()->get();
            $meeting_history = Meetings::where('user_id', \Auth::id())->orderBy('meeting_date', 'DESC')->get();
        } else if (auth()->user()->hasRole('inspector')) {
            $meeting_history = Meetings::where('host_id', \Auth::id())->orderBy('meeting_date', 'DESC')->get();
            $meeting_requests = null;
        }

        return \View::make('history')
            ->with(compact('meeting_requests'))
            ->with(compact('meeting_history'));
    }

    public function request_meeting(Request $request)
    {
        if (auth()->user()->hasRole('customer')) {
            $request->validate([
                'name' => 'required',
                'project_name' => 'required',
                'datepicker' => 'required',
                'time' => 'required',
                'quantity' => 'required',
            ], [
                'name.required' => 'Name is required',
                'project_name.required' => 'Project Name is required',
                'datepicker.required' => 'Request Date is required',
                'time.required' => 'Request Time is required',
                'quantity.required' => 'Quantity is required',
            ]);

            $input = $request->all();
            $req_meeting = new MeetingRequests();
            $req_meeting->user_id = \Auth::id();
            $req_meeting->customer_name = $input['name'];
            $req_meeting->project_name = $input['project_name'];
            $request_date = $input['datepicker'];
            $request_time = $input['time'];
            $combinedDT = date('Y-m-d H:i:s', strtotime("$request_date $request_time"));
            $req_meeting->request_date = $combinedDT;
            $req_meeting->approved = 0;
            $req_meeting->quantity = $input['quantity'];
            $req_meeting->save();

            return back()->with('success', 'Request Meeting has been saved');
        } else {
            return back()->with('error', 'Not Authorized');
        }
    }

    public function approve_meeting(Request $request)
    {
        if (auth()->user()->hasRole('inspector')) {
            $input = $request->all();
            $meeting_request = MeetingRequests::findOrFail($input['id']);

            $report = new Reports();
            $report->user_id = $meeting_request->user_id;
            $report->host_id = \Auth::id();
            $report->save();

            $meeting = new Meetings();
            $meeting->report_id = $report->id;
            $meeting->user_id = $meeting_request->user_id;
            $meeting->customer_name = $meeting_request->customer_name;
            $meeting->project_name = $meeting_request->project_name;
            $meeting->meeting_date = $meeting_request->request_date;
            $meeting->quantity = $meeting_request->quantity;
            $meeting->host_id = \Auth::id();
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $meeting->meeting_link = 'http://' . env('JISTI_URL', 'meet.jit.si') . '/' . substr(str_shuffle($permitted_chars), 0, 10);
            $meeting->approved_date = now();
            $meeting->save();

            $this->store($meeting_request, $meeting->id);

            $meeting_request->approved = 1;
            $meeting_request->save();
            return back()->with('success', 'Request Meeting has been saved');
        }
    }

    public function store($meeting_request, $meeting_id)
    {

        $event = new Event();
        $event->title = $meeting_request->project_name;
        $event->start = new \DateTime($meeting_request->request_date);
        $end_date = new \DateTime($meeting_request->request_date);
        $event->end = $end_date->modify('+ 1 hour');
        $event->user_id = \Auth::id();
        $event->meeting_id = $meeting_id;
        $event->save();
        return redirect('event')->with('success', 'Event has been added');
    }
}
