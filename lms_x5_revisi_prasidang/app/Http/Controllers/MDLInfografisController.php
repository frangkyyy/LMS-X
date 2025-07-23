<?php

namespace App\Http\Controllers;

use App\Models\MDLInfografis;
use App\Models\CourseSubtopik;
use App\Models\DimensionOption;
use Illuminate\Http\Request;

class MDLInfografisController extends Controller
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
    public function create(Request $request)
    {
        $subTopicId = $request->query('sub_topic_id');

        // Ambil sub-topik spesifik berdasarkan sub_topic_id
        $subTopic = CourseSubtopik::findOrFail($subTopicId);
        $learningStyles = DimensionOption::all();
        $subTopics = CourseSubtopik::all();



//            $data = [
//                'menu' => 'menu.v_menu_admin',
//                'content' => 'labels.create',
//                'subTopics' => $subTopics,
//                'learningStyles' =>  $learningStyles,
//                'count_user' => DB::table('users')->count(),
//            ];

//            return view('layouts.v_template', $data);
        return view('infografis.create', compact('learningStyles', 'subTopics','subTopic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validasi input sesuai form create.blade.php
            $validated = $request->validate([
                'learning_style_id' => 'required|exists:opsi_dimensi,id',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'required|array',
                'file_upload.*' => 'file|mimetypes:video/mp4,image/jpeg,image/png|max:5120', // Max 5MB
            ]);

            // Ambil sub_topic
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $uploadedInfografis = [];
            foreach ($request->file('file_upload') as $uploadedFile) {
                // Generate unique filename
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();

                // Store file in storage/app/public/infografis
                $path = $uploadedFile->storeAs('public/infografis', $filename);

                // Simpan data ke database
                $infografisRecord = MDLInfografis::create([
                    'learning_style_id' => $validated['learning_style_id'], // Pastikan ini 1 (visual)
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'file_path' => 'infografis/' . $filename, // Path relatif
                    'created_at' => now(),
                ]);

                $uploadedInfografis[] = $infografisRecord;
            }

            // Redirect dengan pesan sukses
            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', count($uploadedInfografis) . ' infografis berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan infografis: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function show(MDLInfografis $mDLInfografis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLInfografis $mDLInfografis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLInfografis $mDLInfografis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLInfografis $mDLInfografis)
    {
        //
    }
}
