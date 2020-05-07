<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Calendar;

class EventController extends Controller
{
    public function show_calendar()
    {
        $events = [];
        $data = Event::all();
        if($data->count())
            {
            foreach ($data as $key => $value) 
            {
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
                        'url' => '/meetings/detail/'.$value->meeting_id
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);

        return view('dashboard', compact('calendar'));
    }
}
