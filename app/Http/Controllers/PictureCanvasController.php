<?php

namespace App\Http\Controllers;

use App\Events\DrawLine;
use Storage;

class PictureCanvasController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->data = null;
    }
    public function index()
    {
        return view('canvas');
    }

    public function save_picture()
    {
        $upload_dir = "../upload/";
        $img = $_POST['hidden_data'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $filename = 'test.png';

        Storage::disk('local')->put("test.png", $data);
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
