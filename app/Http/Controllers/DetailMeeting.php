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
        $meeting_data = Meetings::findOrFail($id);
        if ($this->is_user_authorized($meeting_data)) {
            return \View::make('detail')
            ->with(compact('meeting_data'));
        }
        else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    public function is_user_authorized($detail) {
        return (auth()->user()->hasRole('customer') && $detail->user_id == \Auth::id()) || (auth()->user()->hasRole('inspector') && $detail->host_id == \Auth::id());
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
