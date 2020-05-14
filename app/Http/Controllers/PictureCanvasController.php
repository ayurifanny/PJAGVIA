<?php

namespace App\Http\Controllers;

class PictureCanvasController extends Controller
{
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
        $file = fopen($filename, 'wb');
        fwrite($file, $data);
        fclose($file);

        return;
    }
}
