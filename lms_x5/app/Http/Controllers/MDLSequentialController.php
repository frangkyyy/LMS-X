<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\MDLFiles;
use App\Models\MDLFolder;
use App\Models\MDLSection;
use App\Models\MDLSequential;
use App\Models\MDLQuiz;
use App\Models\MDLVisual;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class MDLSequentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $course = MDLCourse::find($course_id);
        if (!$course) {
            abort(404, 'Course tidak ditemukan');
        }

        $material = MDLSequential::where('course_id', $course->id)->first();

        $pdfs = MDLFolder::where('course_id', $course->id)->get();

        // Ambil quiz dengan learning_style = sequential
        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'sequential')
            ->first();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'topik1.sequential_global.sequential',
            'title' => $course->full_name,
            'course' => $course,
            'material' => $material,
            'pdfs' => $pdfs,
            'quiz' => $quiz,
        ];

        return view('layouts.v_template', $data);
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
     * @param  \App\Models\MDLSequential  $mDLSequential
     * @return \Illuminate\Http\Response
     */
    public function show($topik, $section_id)
    {
        $section = MDLSection::find($section_id);
        if (!$section) {
            abort(404, "Section dengan ID $section_id tidak ditemukan.");
        }

        // Ambil course berdasarkan nama topik (full_name)
        $course = MDLCourse::find($section->course_id);
        if (!$course) {
            abort(404, "Course tidak ditemukan.");
        }

        // Ambil materi berdasarkan course_id dan section_id
        $material = MDLSequential::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->first();

        $pdfs = MDLFolder::where('course_id', $course->id)->get();

        // Ambil quiz dengan learning_style = sequential
        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'sequential')
            ->first();

        $viewPath = "{$topik}.sequential_global.sequential";
        if (!view()->exists($viewPath)) {
            abort(404, "View untuk topik '{$topik}' tidak ditemukan.");
        }

        // Kirim ke view
        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => $viewPath,
            'title' => $course->full_name,
            'course' => $course,
            'material' => $material,
            'pdfs' => $pdfs,
            'quiz' => $quiz,
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLSequential  $mDLSequential
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLSequential $mDLSequential)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLSequential  $mDLSequential
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLSequential $mDLSequential)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLSequential  $mDLSequential
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLSequential $mDLSequential)
    {
        //
    }
}
