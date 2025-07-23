<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MDLSection;
use App\Models\MDLCourse;
use App\Helpers\LearningStyleHelper;

class TopikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToStyleContent($section_id)
    {
        $section = MDLSection::findOrFail($section_id);

        $course = MDLCourse::find($section->course_id);
        if (!$course) {
            abort(404, "Course dengan ID {$section->course_id} tidak ditemukan.");
        }

        // Ambil kombinasi gaya belajar user
        $styleCombination = LearningStyleHelper::getUserLearningStyleCombination(); // contoh hasil: reflective_intuitive_verbal_global

        if (!$styleCombination) {
            return redirect()->back()->with('error', 'Gaya belajar belum lengkap.');
        }

        // Ubah gaya belajar ke slug format route, misal: acsensvisseq, refintverglob, dll
        $styleSlug = LearningStyleHelper::getStyleSlug($styleCombination); // misalnya return "acsensvisseq"

        // Redirect ke route yang kamu definisikan
        return redirect()->route($styleSlug, [
            'course_id' => $course->id,
            'topik' => $section->id,
            'section_id' => $section->id
        ]);
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
    public function showtopikmahasiswa($course_id, $section_id)
    {
        $user = Auth::user()->load('learning_style');

        $learningStyleIds = $user->learning_style->pluck('id')->toArray();

        $course = MDLCourse::where('id', $course_id)->firstOrFail();

        $section = MDLSection::with([
            'sub_topic.labels' => function ($query) use ($learningStyleIds) {
                // Filter halaman berdasarkan learning_style_id pengguna
                $query->whereIn('learning_style_id', $learningStyleIds);
            },
            'sub_topic.files' => function ($query) use ($learningStyleIds) {
                // Filter halaman berdasarkan learning_style_id pengguna
                $query->whereIn('learning_style_id', $learningStyleIds);
            },
            'sub_topic.infografis' => function ($query) use ($learningStyleIds) {
                // Filter halaman berdasarkan learning_style_id pengguna
                $query->whereIn('learning_style_id', $learningStyleIds);
            },
            'sub_topic.folders' => function ($query) use ($learningStyleIds) {
                // Filter halaman berdasarkan learning_style_id pengguna
                $query->whereIn('learning_style_id', $learningStyleIds);
            },
            'sub_topic.pages' => function ($query) use ($learningStyleIds) {
                // Filter halaman berdasarkan learning_style_id pengguna
                $query->whereIn('learning_style_id', $learningStyleIds);
            },
//            'sub_topic.urls' => function ($query) use ($learningStyleIds) {
//                // Filter halaman berdasarkan learning_style_id pengguna
//                $query->whereIn('learning_style_id', $learningStyleIds);
//            },
            'sub_topic.quizs',
//            'sub_topic.assignments',
            'referensi'

        ])
            ->where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        // Ambil semua topik untuk kursus (untuk navigasi atau keperluan lain)
        $sections = MDLSection::where('course_id', $course_id)
            ->where('visible', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Hitung indeks topik saat ini
        $indeks = $sections->search(function ($item) use ($section) {
                return $item->id == $section->id;
            }) + 1;

        // Siapkan data untuk tampilan
        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => in_array(7, $learningStyleIds) ? 'course.sectionShowMahasiswa' : 'course.sectionGlobalShowMahasiswa',
            'indeks' => $indeks,
            'title' => $section->title,
            'course' => $course,
            'section' => $section, // Tetap gunakan 'section' di view untuk konsistensi
        ];

        return view('layouts.v_template',$data);
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
