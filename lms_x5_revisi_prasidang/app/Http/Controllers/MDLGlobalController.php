<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\MDLFiles;
use App\Models\MDLForum;
use App\Models\MDLGlobal;
use App\Models\MDLSection;
use App\Models\MDLVisual;
use Illuminate\Http\Request;

class MDLGlobalController extends Controller
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

        $material = MDLGlobal::where('course_id', $course->id)->first();

        $videos = MDLFiles::where('course_id', $course->id)
            ->where('type', 'global-video')
            ->get();

        $files = MDLFiles::where('course_id', $course->id)
            ->where('type', 'global-link')
            ->get();

        // Ambil satu gambar (type = image)
        $image = MDLFiles::where('course_id', $course->id)
            ->where('type', 'global-image')
            ->first();

        $forum = MDLForum::with('posts.user')
            ->where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->first();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'topik1.sequential_global.global',
            'title' => $course->full_name,
            'course' => $course,
            'material' => $material,
            'files' => $files,
            'image' => $image,
            'forum' => $forum,
            'videos' => $videos,
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
     * @param  \App\Models\MDLGlobal  $mDLGlobal
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
        $material = MDLGlobal::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->first();

        $videos = MDLFiles::where('course_id', $course->id)
            ->where('type', 'global-video')
            ->get();

        $files = MDLFiles::where('course_id', $course->id)
            ->where('type', 'global-link')
            ->get();

        // Ambil satu gambar (type = image)
        $image = MDLFiles::where('course_id', $course->id)
            ->where('type', 'global-image')
            ->first();

        $forum = MDLForum::with('posts.user')
            ->where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->first();

        $viewPath = "{$topik}.sequential_global.global";
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
            'forum' => $forum,
            'videos' => $videos,
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLGlobal  $mDLGlobal
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLGlobal $mDLGlobal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLGlobal  $mDLGlobal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLGlobal $mDLGlobal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLGlobal  $mDLGlobal
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLGlobal $mDLGlobal)
    {
        //
    }
}
