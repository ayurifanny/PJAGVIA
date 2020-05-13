<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PictureCanvasController extends Controller
{
    public function index() {
        return view('canvas');
    }
}
