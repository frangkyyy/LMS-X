<?php

namespace App\Http\Controllers;

use App\Models\MDLAssignSubmission;
use Illuminate\Http\Request;

class MDLAssignSubmissionController extends Controller
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
     * @param  \App\Models\MDLAssignSubmission  $mDLAssignSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(MDLAssignSubmission $mDLAssignSubmission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLAssignSubmission  $mDLAssignSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLAssignSubmission $mDLAssignSubmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLAssignSubmission  $mDLAssignSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLAssignSubmission $mDLAssignSubmission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLAssignSubmission  $mDLAssignSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLAssignSubmission $mDLAssignSubmission)
    {
        //
    }

    public function cancel(Request $request)
    {
        $submission = \App\Models\MDLAssignSubmission::find($request->submission_id);

        if (!$submission || $submission->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan submission ini.');
        }

        // Hapus file dari penyimpanan jika ada
        if ($submission->file_path && file_exists(public_path($submission->file_path))) {
            unlink(public_path($submission->file_path));
        }

        $submission->delete();

        return redirect()->back()->with('success', 'Submission berhasil dibatalkan. Silakan unggah ulang jika diperlukan.');
    }
}
