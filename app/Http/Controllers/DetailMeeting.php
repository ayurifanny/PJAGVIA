<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meetings;

class DetailMeeting extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $detail = Meetings::findOrFail($id);
        if (auth()->user()->hasRole('customer') && $detail->user_id == \Auth::id()) {
            return view('detail');
        }
        else if (auth()->user()->hasRole('inspector') && $detail->host_id == \Auth::id()) {
            // $meeting_requests =  MeetingRequests::where('approved', 0)->latest()->get();
            return view('detail');
        }
        else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
}
