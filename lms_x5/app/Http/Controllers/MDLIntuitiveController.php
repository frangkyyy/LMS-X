<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\MDLFiles;
use App\Models\MDLIntuitive;
use App\Models\MDLSection;
use App\Models\MDLSensing;
use Illuminate\Http\Request;

class MDLIntuitiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        // Ambil data course
        $course = MDLCourse::where('id', $course_id)->first();
        if (!$course) {
            abort(404, "Course dengan ID $course_id tidak ditemukan.");
        }

        // Ambil satu materi utama (misalnya yang pertama)
        $material = MDLIntuitive::where('course_id', $course->id)->first();

        // Ambil semua file yang terhubung dengan materi intuitive
        $files = MDLFiles::where('course_id', $course->id)
            ->where('type', 'like', '%intuitive%')
            ->get();

        // Kirim data ke view
        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'topik1.sensing_intuitive.intuitive',
            'title' => $course->full_name,
            'course' => $course,
            'material' => $material,
            'files' => $files,
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
     * @param  \App\Models\MDLIntuitive  $mDLIntuitive
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
        $material = MDLIntuitive::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->first();

        // Ambil semua file yang berelasi dengan materi intuitive
        $files = MDLFiles::where('course_id', $course->id)
            ->where('type', 'like', '%intuitive%')
            ->get();

        $viewPath = "{$topik}.sensing_intuitive.intuitive";
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
        ];

        return view('layouts.v_template', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLIntuitive  $mDLIntuitive
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLIntuitive $mDLIntuitive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLIntuitive  $mDLIntuitive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLIntuitive $mDLIntuitive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLIntuitive  $mDLIntuitive
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLIntuitive $mDLIntuitive)
    {
        //
    }
}
