<?php

namespace App\Http\Controllers;

use App\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return \View::make('admin')
            ->with(compact('users'));
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
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $Users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $Users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $Users)
    {
        //
    }
}
