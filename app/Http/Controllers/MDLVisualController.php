<?php

namespace App\Http\Controllers;

use App\Models\MDLActive;
use App\Models\MDLCourse;
use App\Models\MDLFiles;
use App\Models\MDLSection;
use App\Models\MDLSensing;
use App\Models\MDLVisual;
use Illuminate\Http\Request;

class MDLVisualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $course = MDLCourse::where('id', $course_id)->first();
        if (!$course) {
            abort(404, "Course tidak ditemukan.");
        }

        $material = MDLVisual::where('course_id', $course->id)->first();

        // Ambil semua file video dari YouTube
        $files = MDLFiles::where('course_id', $course->id)
            ->where('type', 'visual-video')
            ->get();

        // Ambil satu gambar (type = image)
        $image = MDLFiles::where('course_id', $course->id)
            ->where('type', 'visual-image')
            ->first();

        // Ambil satu file PDF
        $pdf = MDLFiles::where('course_id', $course->id)
            ->where('file_path', 'like', '%.pdf')
            ->first();

        $pdfs = MDLFiles::where('course_id', $course->id)
            ->where('type', 'visual-pdf')
            ->where('file_path', 'like', '%.pdf')
            ->get();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'topik1.visual_verbal.visual',
            'title' => $course->full_name,
            'course' => $course,
            'material' => $material,
            'files' => $files,
            'image' => $image,
            'pdf' => $pdf,
            'pdfs' => $pdfs,
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
     * @param  \App\Models\MDLVisual  $mDLVisual
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
        $material = MDLVisual::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->first();

        $files = MDLFiles::where('course_id', $course->id)
            ->where('type', 'visual-video')
            ->get();

        // Ambil satu gambar (type = image)
        $image = MDLFiles::where('course_id', $course->id)
            ->where('type', 'visual-image')
            ->first();

        // Ambil satu file PDF
        $pdf = MDLFiles::where('course_id', $course->id)
            ->where('file_path', 'like', '%.pdf')
            ->first();

        $pdfs = MDLFiles::where('course_id', $course->id)
            ->where('type', 'visual-pdf')
            ->where('file_path', 'like', '%.pdf')
            ->get();

        $viewPath = "{$topik}.visual_verbal.visual";
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
            'files' => $files,
            'image' => $image,
            'pdf' => $pdf,
            'pdfs' => $pdfs,
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLVisual  $mDLVisual
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLVisual $mDLVisual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLVisual  $mDLVisual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLVisual $mDLVisual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLVisual  $mDLVisual
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLVisual $mDLVisual)
    {
        //
    }
}
