<?php

namespace App\Http\Controllers;

use App\Models\MDLFolder;
use Illuminate\Http\Request;

class MDLFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {

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
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function show(MDLFolder $mDLFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLFolder $mDLFolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLFolder $mDLFolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLFolder $mDLFolder)
    {
        //
    }
}
