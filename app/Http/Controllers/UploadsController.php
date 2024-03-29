<?php

namespace App\Http\Controllers;

use App\Reports;
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
    public function destroy($id)
    {
        if (\Auth::user()->hasRole('inspector')) {
            $upload = Uploads::findOrFail($id);
            if ($upload->approved == -1) {
                Storage::disk('public')->delete($upload->meeting_id . "/" . $upload->photo);
                $upload->delete();
                return back()->with('success', 'Picture Deleted deleted');
            }
        }
        abort(403, 'Unauthorized action.');
    }

    public function upload(Request $request)
    {
        $files = $request->file('file');
        if (!empty($files)):
            $x = 0;
            foreach ($files as $file):
                try {
                    $x++;
                    $filename = "II-" . str_pad($request['id'], 3, '0', STR_PAD_LEFT) . "-" . $file->getClientOriginalName();
                    $image = Image::make($file);

                    if ($image->width() > 700) {
                        $image->resize(700, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save(Storage::disk('public')->path($request['id'] . '/' . $filename));
                        #Storage::disk('public')->put($request['id'] . '/' . $filename, $image);
                    } else if ($image->height() > 700) {
                    $image->resize(null, 700, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save(Storage::disk('public')->path($request['id'] . '/' . $filename));
                } else {
                    Storage::disk('public')->put($request['id'] . '/' . $filename, file_get_contents($file));
                }
            } catch (Throwable $e) {
                abort(404, "Cannot Upload Photo");
            }

            $upload = new Uploads();
            $upload->meeting_id = $request['id'];
            $upload->photo = $filename;
            $upload->approved = -1;
            $upload->save();

        endforeach;
        endif;

        return back();
    }

    public function upload_sign(Request $request)
    {

        $file = $request->file('file');
        $report = Reports::findOrFail($request['id']);
        $role = $request['role'];

        if ($role == 'inspector') {
            $user = $report->host_id;
        } else {
            $user = $report->user_id;
        }

        if (!empty($file)):
            $filename = "sign-" . $request['id'] . '.png';
            $image = Image::make($file);

            if ($image->width() > 500) {
                $image->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->stream();
                Storage::disk('public')->put('sign/' . $user . '/' . $filename, $image);
            } else if ($image->height() > 500) {
            $image->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->stream();
            Storage::disk('public')->put('sign/' . $user . '/' . $filename, $image);
        } else {
            Storage::disk('public')->put('sign/' . $user . '/' . $filename, file_get_contents($file));
        }

        if ($role == 'inspector') {
            $report->inspector_signature = $filename;
        } else {
            $report->customer_signature = $filename;
        }
        $report->save();

        endif;

        return redirect()->back();
    }
}
