<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\MDLActive;
use App\Models\MDLFiles;
use App\Models\MDLForum;
use App\Models\MDLQuiz;
use App\Models\MDLSection;
use App\Models\MDLSequential;
use Illuminate\Http\Request;

class MDLActiveController extends Controller
{
    /**
     * Display a listing of the resource for a specific course and section.
     *
     * @param  int  $course_id
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $course = MDLCourse::where('id', $course_id)->first();
        if (!$course) {
            abort(404, "Course dengan ID $course_id tidak ditemukan.");
        }

        $material = MDLActive::where('course_id', $course->id)->first();

        $forum = MDLForum::with('posts.user')->where('course_id', $course_id)->first();
//        $video = MDLActive::where('course_id', $course_id)->where('content_type', 'video')->first();
        $filesVideo = MDLFiles::where('course_id', $course->id)
            ->where('type', 'active-video')
            ->where('topik', 'topik1')
            ->get();

        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'active')
            ->first();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'topik1.active_reflective.active',
            'title' => $course->full_name,
            'course' => $course,
            'material' => $material,
            'quiz' => $quiz,
            'forum' => $forum,
            'files_video' => $filesVideo,
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
        // Logika untuk membuat resource baru, jika diperlukan
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Logika untuk menyimpan data baru, jika diperlukan
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLActive  $mDLActive
     * @return \Illuminate\Http\Response
     */
    public function show($topik, $section_id)
    {
        // Ambil data section
        $section = MDLSection::find($section_id);
        if (!$section) {
            abort(404, "Section dengan ID $section_id tidak ditemukan.");
        }

        // Ambil data course berdasarkan section
        $course = MDLCourse::find($section->course_id);
        if (!$course) {
            abort(404, "Course dengan ID {$section->course_id} tidak ditemukan.");
        }

        // Ambil materi berdasarkan course dan section
        $materials = MDLActive::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->get();

        // Ambil video berdasarkan course_id, type, learning_style, dan topik
        $filesVideo = MDLFiles::where('course_id', $course->id)
            ->where('type', 'active-video')
            ->where('learning_style', 'active')
            ->where('topik', $topik)
            ->get();

        // Ambil quiz berdasarkan course_id, learning_style, dan topik
        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'active')
            ->where('topik', $topik)
            ->get();

        // Ambil forum berdasarkan course_id, section_id, learning_style, dan topik
        $forum = MDLForum::with('posts.user')
            ->where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->where('learning_style', 'active')
            ->where('topik', $topik)
            ->get();

        // Buat path view dari parameter topik
        $viewPath = "{$topik}.active_reflective.active";
        if (!view()->exists($viewPath)) {
            abort(404, "View untuk topik '{$topik}' tidak ditemukan.");
        }

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => $viewPath,
            'title' => $course->full_name,
            'course' => $course,
            'sections' => $materials,
            'material' => $materials->first(),
            'forum' => $forum,
            'filesVideo' => $filesVideo,
            'quiz' => $quiz,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLActive  $mDLActive
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLActive $mDLActive)
    {
        // Logika untuk edit resource, jika diperlukan
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLActive  $mDLActive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLActive $mDLActive)
    {
        // Logika untuk update resource, jika diperlukan
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLActive  $mDLActive
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLActive $mDLActive)
    {
        // Logika untuk menghapus resource, jika diperlukan
    }
}
