<?php

namespace App\Http\Controllers;

use App\Models\MDLFileSave;
use App\Models\MDLFolder;

use Illuminate\Http\Request;

class MDLFileSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($folder_id)
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
     * @param  \App\Models\MDLFileSave  $mDLFileSave
     * @return \Illuminate\Http\Response
     */
    public function show( $folder_id)
    {
        // Ambil folder
        $folder = MDLFileSave::findOrFail($folder_id);

        // Ambil semua file dalam folder (yang tidak dihapus secara soft delete)
        $files = $folder->files_save()->whereNull('deleted_at')->get();

        // Ambil data tambahan untuk breadcrumb
        // $subTopic = $folder->sub_topic;
        // $section = $subTopic->section; // Asumsi relasi sub_topic ke section ada
        // $course = $section->course; // Asumsi relasi section ke course ada

        return view('folders.show', compact('folder', 'files'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLFileSave  $mDLFileSave
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLFileSave $mDLFileSave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLFileSave  $mDLFileSave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLFileSave $mDLFileSave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLFileSave  $mDLFileSave
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLFileSave $mDLFileSave)
    {
        //
    }
}
