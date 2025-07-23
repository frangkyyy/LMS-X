<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MDLUserLearningStyles;
use App\Models\MDLCourse;
use App\Models\MDLSection;
use App\Models\ContentRecommendation;
use App\Models\MDLCourseModules;
use Illuminate\Support\Facades\Auth;
class LearningContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $userId = Auth::id();

        // Ambil data gaya belajar mahasiswa
        $userLearningStyles = MDLUserLearningStyles::where('user_id', $userId)->get();

        // Mapping gaya belajar ke file Blade yang sesuai
        $viewMap = [
            'Active'     => 'active_reflective.active',
            'Reflective' => 'active_reflective.reflective',
            'Sensing'    => 'sensing_intuitive.sensing',
            'Intuitive'  => 'sensing_intuitive.intuitive',
            'Visual'     => 'visual_verbal.visual',
            'Verbal'     => 'visual_verbal.verbal',
            'Sequential' => 'sequential_global.sequential',
            'Global'     => 'sequential_global.global',
        ];

        // Ambil gaya belajar utama dengan skor tertinggi
        $dominantStyle = null;
        $highestScore = 0;

        foreach ($userLearningStyles as $style) {
            $score = intval($style->final_score);
            $styleName = preg_replace('/^\d+/', '', $style->final_score);

            if ($score > $highestScore) {
                $highestScore = $score;
                $dominantStyle = $styleName;
            }
        }

        // Jika tidak ada gaya belajar dominan, gunakan default
        $view = $viewMap[$dominantStyle] ?? 'learning.default';

        // Ambil data course berdasarkan ID
        $course = MDLCourse::where('id', $course_id)->first();
        if (!$course) {
            abort(404, "Course dengan ID $course_id tidak ditemukan.");
        }

        // Ambil semua section yang terkait dengan course ini dan visible
        $sections = MDLSection::where('course_id', $course_id)
            ->where('visible', 1)
            ->get();

        // Kirim data ke template utama
        $data = [
            'menu' => 'menu.v_menu_admin', // Pastikan menu ini ada
            'content' => $view, // Konten berubah sesuai gaya belajar
            'title' => $course->full_name,
            'course' => $course,
            'sections' => $sections,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
