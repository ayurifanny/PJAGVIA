<?php

namespace App\Http\Controllers;

use App\Uploads;
use Illuminate\Http\Request;
use Image;
use Storage;

class UploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function show(Uploads $uploads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function edit(Uploads $uploads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uploads $uploads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uploads $uploads)
    {
        //
    }

    public function upload(Request $request)
    {
        $files = $request->file('file');
        if (!empty($files)):
            foreach ($files as $file):
                $image = Image::make($file);
                if ($image->height() > 1000 || $image->width() > 1000) {
                    $image->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->stream();
                }

                Storage::disk('public')->put($request['id'] . '/' . $file->getClientOriginalName(), $image);

                $upload = new Uploads();
                $upload->meeting_id = $request['id'];
                $upload->photo = $file->getClientOriginalName();
                $upload->approved = -1;
                $upload->save();
            endforeach;
        endif;

        return back();
    }
}
