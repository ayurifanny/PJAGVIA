<?php

namespace App\Http\Controllers;

use App\Events\DrawLine;
use App\Uploads;
use Storage;

class PictureCanvasController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->data = null;
    }
    public function index($id)
    {
        $pic = Uploads::findOrFail($id);
        return \View::make('canvas')
            ->with(compact('pic'));
    }

    public function save_picture()
    {
        $upload_dir = "../upload/";
        $img = $_POST['hidden_data'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $fn = explode('.', $_POST['file_name']);
        $filename = $_POST['meeting_id'] . '/' . $fn[0] . '_edited.png';

        Storage::disk('public')->put($filename, $data);

        $upload = Uploads::where('photo', $_POST['file_name'])->where('meeting_id', $_POST['meeting_id'])->get();
        $upload[0]->photo_edited = $fn[0] . '_edited.png';
        $upload[0]->save();
        dd("stored");
        return;
    }

    public function send_stroke()
    {
        $data = $_POST['strokes'];
        $this->call_event($data);
        return;
    }

    public function call_event($data)
    {
        event(new DrawLine($data));
        return;
    }
}
