<?php

namespace App\Http\Controllers;

use App\Models\MDLFiles;
use App\Models\CourseSubtopik;
use App\Models\DimensionOption;
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
        return view('files.create', compact('learningStyles', 'subTopics','subTopic'));
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
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'learning_style_id' => 'required|exists:opsi_dimensi,id',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'required|array',
                'file_upload.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:5120',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $uploadedFiles = [];
            foreach ($request->file('file_upload') as $uploadedFile) {
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();

                // Simpan file ke storage/public/files
                $path = $uploadedFile->storeAs('public/files', $filename);

                $fileRecord = MDLFiles::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'learning_style_id' => $validated['learning_style_id'],
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'file_path' => 'files/' . $filename, // Perhatikan perubahan disini
                    'original_filename' => $uploadedFile->getClientOriginalName(),
                ]);

                $uploadedFiles[] = $fileRecord;
            }

            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', count($uploadedFiles) . ' file berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function storeinfografis(Request $request)
    {
        try {
            // Validasi input sesuai form createinfografis.blade.php
            $validated = $request->validate([
                'learning_style_id' => 'required|exists:opsi_dimensi,id',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'required|array',
                'file_upload.*' => 'file|mimetypes:video/mp4,image/jpeg,image/png|max:5120', // Max 5MB
            ]);

            // Ambil sub_topic
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $uploadedFiles = [];
            foreach ($request->file('file_upload') as $uploadedFile) {
                // Generate unique filename
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();

                // Store file in storage/app/public/files
                $path = $uploadedFile->storeAs('public/files', $filename);

                // Simpan data ke database
                $fileRecord = MDLFiles::create([
                    'name' => $uploadedFile->getClientOriginalName(), // Nama file asli
                    'description' => 'Infografis untuk ' . $subTopic->title, // Deskripsi default
                    'learning_style_id' => $validated['learning_style_id'], // Pastikan ini 1 (visual)
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'file_path' => 'files/' . $filename, // Path relatif
                    'original_filename' => $uploadedFile->getClientOriginalName(),
                    'created_at' => now(),
                ]);

                $uploadedFiles[] = $fileRecord;
            }

            // Redirect dengan pesan sukses
            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', count($uploadedFiles) . ' infografis berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan infografis: ' . $e->getMessage()])
                ->withInput();
        }
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
    public function update(Request $request )
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
