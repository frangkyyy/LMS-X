<?php

namespace App\Http\Controllers;

use App\Models\MDLFiles;
use Illuminate\Http\Request;

class MDLFileController extends Controller
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
        $learningStyles = MDLFiles::select('learning_style')
                            ->distinct()
                            ->whereNotNull('learning_style')
                            ->pluck('learning_style');

        $topik = MDLFiles::select('topik')
                            ->distinct()
                            ->whereNotNull('topik')
                            ->pluck('topik');

        $type = MDLFiles::select('type')
                            ->distinct()
                            ->whereNotNull('type')
                            ->pluck('type');
    
        return view('files.create', compact('learningStyles', 'topik', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:mdl_course,id',
            'learning_style' => 'required|string',
            'topik' => 'required|string',
            'tipe' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('file')->store('files', 'public');

    
        MDLFiles::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'course_id' => $request->course_id,
            'learning_style' => $request->learning_style,
            'topik' => $request->topik,
            'type' => $request->tipe,
            'file_path' => 'storage/' . $path,
            'created_at' => now(),
        ]);
        return redirect()->back()->with('success', 'File berhasil diunggah!');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
