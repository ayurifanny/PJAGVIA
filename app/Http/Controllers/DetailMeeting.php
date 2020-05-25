<?php

namespace App\Http\Controllers;

use App\Meetings;
use App\Uploads;
use Illuminate\Http\Request;
use PDF;

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
        $picture_data = Uploads::where('meeting_id', $id)->get();
        if ($this->is_user_authorized($meeting_data)) {
            return \View::make('detail')
                ->with(compact('meeting_data'))
                ->with(compact('picture_data'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function is_user_authorized($detail)
    {
        return (auth()->user()->hasRole('customer') && $detail->user_id == \Auth::id()) || (auth()->user()->hasRole('inspector') && $detail->host_id == \Auth::id());
    }

    public function download_pdf($id)
    {
        $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        $pdf = PDF::loadView('pdf', $data);

        return $pdf->download('itsolutionstuff.pdf');
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
