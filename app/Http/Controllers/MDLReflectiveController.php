<?php

namespace App\Http\Controllers;

use App\Models\MDLReflective;
use App\Models\MDLFiles;
use App\Models\MDLCourse;
use App\Models\MDLForum;
use App\Models\MDLForumPost;
use App\Models\MDLSection;
use Illuminate\Http\Request;

class MDLReflectiveController extends Controller
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
            abort(404, "Course dengan ID $course_id tidak ditemukan.");
        }

        $files = MDLFiles::where('course_id', $course->id)
            ->whereIn('type', ['reflective-link', 'reflective-pdf'])
            ->get();

        $material = MDLReflective::where('course_id', $course->id)->first();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'topik1.active_reflective.reflective',
            'title' => $course->full_name,
            'course' => $course,
            'files' => $files,
            'material' => $material,
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
     * @param  \App\Models\MDLReflective  $mDLReflective
     * @return \Illuminate\Http\Response
     */
    public function show($topik, $section_id)
    {
        // Ambil data course dari section
        $section = MDLSection::find($section_id);
        if (!$section) {
            abort(404, "Section dengan ID $section_id tidak ditemukan.");
        }

        $course = MDLCourse::find($section->course_id);
        if (!$course) {
            abort(404, "Course tidak ditemukan.");
        }

        // Ambil konten reflective berdasarkan course dan section
        $materials = MDLReflective::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->get();

        //Ambil image
        $files = MDLFiles::where('course_id', $course->id)
            ->whereIn('type', ['reflective-link', 'reflective-pdf'])
            ->get();

        // Forum (jika ada)
        $forum = MDLForum::with('posts.user')
            ->where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topik)
            ->first();

        $viewPath = "{$topik}.active_reflective.reflective";
        if (!view()->exists($viewPath)) {
            abort(404, "View untuk topik '{$topik}' tidak ditemukan.");
        }

        // Menyiapkan data untuk tampilan
        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => $viewPath,
            'title' => $course->full_name,
            'course' => $course,
            'material' => $materials->first(),
            'sections' => $materials,
            'forum' => $forum,
            'files' => $files,
        ];

        // Mengembalikan view
        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLReflective  $mDLReflective
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLReflective $mDLReflective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLReflective  $mDLReflective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLReflective $mDLReflective)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLReflective  $mDLReflective
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLReflective $mDLReflective)
    {
        //
    }
}
