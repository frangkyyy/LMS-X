<?php

namespace App\Http\Controllers;

use App\Models\MDLAssign;
use App\Models\MDLCourse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MDLAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = MDLAssign::all();
        return view('assignments.index', compact('assignments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $learningStyles = MDLAssign::select('learning_style')
            ->distinct()
            ->whereNotNull('learning_style')
            ->pluck('learning_style');

        $topik = MDLAssign::select('topik')
            ->distinct()
            ->whereNotNull('topik')
            ->pluck('topik');

        return view('assignments.create', compact('learningStyles', 'topik'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:64000',
            'course_id' => 'required|exists:mdl_course,id',
        ]);

        // Simpan data assignment ke tabel mdl_assign
        $assignment = new MDLAssign();
        $assignment->name = $request->input('name');
        $assignment->description = $request->input('description');
        $assignment->due_date = Carbon::parse($request->input('due_date'));
        $assignment->course_id = $request->course_id;
        $assignment->learning_style = $request->input('learning_style', 'default'); // Menangani learning_style
        $assignment->topik = $request->input('topik', 'General'); // Menangani topik

        $assignment->created_at = now();

        // Jika ada file yang diupload
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('assignments', 'public');
            $assignment->file_path = 'storage/' . $path;
        }

        $assignment->save();

        return redirect()->back()->with('success', 'Assignment berhasil dibuat!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function show(MDLAssign $mDLAssign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLAssign $mDLAssign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLAssign $mDLAssign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLAssign $mDLAssign)
    {
        //
    }

    public function submit(Request $request)
    {
        $request->validate([
            'assign_id' => 'required|exists:mdl_assign,id',
            'user_id' => 'required|exists:users,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('file_path')->store('assignments', 'public');

        \App\Models\MDLAssignSubmission::create([
            'assign_id' => $request->assign_id,
            'user_id' => $request->user_id,
            'file_path' => 'storage/' . $path,
            'status' => 'submitted',
            'created_at' => now(),
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
