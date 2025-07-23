<?php

namespace App\Http\Controllers;

use App\Models\MDLAssignGrades;
use App\Models\MDLAssign;
use App\Models\MDLAssignSubmission;
use Illuminate\Http\Request;

class MDLAssignGradesController extends Controller
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
    public function create(MDLAssign $assignment, MDLAssignSubmission $submission)
    {
        // Pastikan submission milik assignment yang benar
        if ($submission->assign_id != $assignment->id) {
            abort(404);
        }

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'assignments.grade',
            'title' => 'Grade Assignment',
            'assignment' => $assignment,
            'submission' => $submission,
            'grade' => $submission->grade ?? null
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MDLAssign $assignment, MDLAssignSubmission $submission)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $existingGrade = MDLAssignGrades::where('assign_id', $assignment->id)
            ->where('submission_id', $submission->id)
            ->first();

        if ($existingGrade) {
            $existingGrade->update([
                'grade' => $request->grade,
                'feedback' => $request->feedback,
                'updated_at' => now()
            ]);
        } else {
            MDLAssignGrades::create([
                'assign_id' => $assignment->id,
                'submission_id' => $submission->id, // Pastikan ini diisi
                'user_id' => $submission->user_id,
                'grade' => $request->grade,
                'feedback' => $request->feedback,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('assignments.showAssignmentDosen', $assignment->id)
            ->with('success', 'Grade berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLAssignGrades  $mDLAssignGrades
     * @return \Illuminate\Http\Response
     */
    public function show(MDLAssignGrades $mDLAssignGrades)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLAssignGrades  $mDLAssignGrades
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLAssignGrades $mDLAssignGrades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLAssignGrades  $mDLAssignGrades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLAssignGrades $mDLAssignGrades)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLAssignGrades  $mDLAssignGrades
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLAssignGrades $mDLAssignGrades)
    {
        //
    }
}
