<?php

namespace App\Http\Controllers;

use App\Models\MDLAssign;
use App\Models\MDLCourse;
use App\Models\MDLFiles;
use App\Models\MDLFolder;
use App\Models\MDLForum;
use App\Models\MDLGlobal;
use App\Models\MDLPage;
use App\Models\MDLQuiz;
use App\Models\MDLQuizAttempts;
use App\Models\MDLQuizGrades;
use App\Models\MDLReflective;
use App\Models\MDLSection;
use App\Models\MDLSensing;
use App\Models\MDLSequential;
use App\Models\MDLUserLearningStyles;
use App\Models\MDLVerbal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReflectiveSensingVerbalGlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id, $topik, $section_id)
    {
        $user = Auth::user();

        $course = MDLCourse::find($course_id);
        if (!$course) {
            abort(404, "Course dengan ID $course_id tidak ditemukan.");
        }

        // Ambil data section
        $section = MDLSection::find($section_id);
        if (!$section) {
            abort(404, "Section dengan ID $section_id tidak ditemukan.");
        }

        $topikKey = 'topik' . $topik;

        // Gaya Belajar Reflective
        $reflectiveFiles = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->whereIn('type', ['reflective-pdf', 'reflective-link'])
            ->get();

        $imageFiles = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->where('type', 'reflective-image')
            ->get();

        $videoFiles = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->where('type', 'reflective-video')
            ->get();

        $assignments = MDLAssign::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->get();

        $forum = MDLForum::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->with(['posts.user'])->get();

        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->first();

        $pageFilesReflective = MDLPage::where('course_id', $course->id)
            ->where('learning_style', 'reflective')
            ->where('topik', $topikKey)
            ->where('type', 'like', 'reflective-%')
            ->get();

        // Gaya Belajar Sensing
        $sensingMaterials = MDLSensing::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->get();

        $sensingFiles = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->whereIn('type', ['sensing-pdf', 'sensing-link'])
            ->get();

        $sensingImage = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->where('type', 'sensing-image')
            ->get();

        $sensingVideo = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->where('type', 'sensing-video')
            ->get();

        $sensingAssignments = MDLAssign::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->get();

        $sensingForum = MDLForum::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->with(['posts.user'])->get();

        $sensingQuiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->get();

        $pageFilesSensing = MDLPage::where('course_id', $course->id)
            ->where('learning_style', 'sensing')
            ->where('topik', $topikKey)
            ->where('type', 'like', 'sensing-%')
            ->get();

        // Gaya Belajar Verbal
        $verbalMaterial = MDLVerbal::where('course_id', $course_id)->first();

        $verbalPdfs = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->whereIn('type', ['verbal-pdf', 'verbal-link'])
            ->get();

        $verbalImages = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->where('type', 'verbal-image')
            ->get();

        $youtubeVideos = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->where('type', 'verbal-video')
            ->get();

        $verbalAssignments = MDLAssign::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->get();

        $verbalForums = MDLForum::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->with(['posts.user'])->get();

        $verbalQuiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->first();

        $pageFilesVerbal = MDLPage::where('course_id', $course->id)
            ->where('learning_style', 'verbal')
            ->where('topik', $topikKey)
            ->where('type', 'like', 'verbal-%')
            ->get();

        // Gaya Belajar Global
        $globalMaterial = MDLGlobal::where('course_id', $course_id)->first();

        $globalPdfs = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->whereIn('type', ['global-pdf', 'global-link'])
            ->get(); // jika ada topik tertentu bisa difilter juga

        $globalImage = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->where('type', 'global-image')
            ->get();

        $globalVideo = MDLFiles::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->where('type', 'global-video')
            ->get();

        $globalAssignments = MDLAssign::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->get();

        $globalForum = MDLForum::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->with(['posts.user'])->get();

        $globalQuiz = MDLQuiz::where('course_id', $course_id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->first();

        $pageFilesGlobal = MDLPage::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->where('topik', $topikKey)
            ->where('type', 'like', 'global-%')
            ->get();

        $quiz_attempt = null;
        $quiz_grade = null;

        if ($globalQuiz) {
            $quiz_attempt = MDLQuizAttempts::where('quiz_id', $globalQuiz->id)
                ->where('user_id', Auth::id())
                ->latest()
                ->first();

            $quiz_grade = MDLQuizGrades::where('quiz_id', $globalQuiz->id)
                ->where('user_id', Auth::id())
                ->latest()
                ->first();
        }

        // Ambil data gaya belajar berdasarkan final_score dan category
        $learningStyles = MDLUserLearningStyles::where('user_id', $user->id)->get();

        $dimensionLabels = [
            'ACT/REF' => ['Active', 'Reflective'],
            'SNS/INT' => ['Sensing', 'Intuitive'],
            'VIS/VRB' => ['Visual', 'Verbal'],
            'SEQ/GLO' => ['Sequential', 'Global'],
        ];

        $scores = [];

        foreach ($learningStyles as $style) {
            $dimension = $style->dimension;

            // Ambil nama gaya dari final_score, contoh: "5Active" -> "Active"
            preg_match('/[A-Za-z]+$/', $style->final_score, $matches);
            $label = $matches[0] ?? $dimensionLabels[$dimension][0];

            $scores[$dimension] = [
                'label' => $label,
                'category' => $style->category,
            ];
        }

        $descriptions = [
            'ACT/REF' => [
                'Reflective' => [
                    'Balanced' => 'Anda seimbang dalam belajar mandiri dan diskusi',
                    'Moderate' => 'Anda cukup suka belajar melalui refleksi dan berpikir',
                    'Strong' => 'Anda sangat suka belajar mandiri melalui refleksi sebelum bertindak',
                ],
            ],
            'SNS/INT' => [
                'Sensing' => [
                    'Balanced' => 'Anda seimbang antara mempelajari fakta konkret dan teori abstrak',
                    'Moderate' => 'Anda cukup nyaman dengan fakta konkret dan detail praktis',
                    'Strong' => 'Anda lebih suka belajar melalui fakta nyata dan pengalaman langsung',
                ],
            ],
            'VIS/VRB' => [
                'Verbal' => [
                    'Balanced' => 'Anda seimbang dalam memahami informasi visual dan verbal',
                    'Moderate' => 'Anda cukup nyaman memahami melalui penjelasan lisan atau tulisan',
                    'Strong' => 'Anda sangat nyaman belajar lewat bacaan dan penjelasan lisan',
                ],
            ],
            'SEQ/GLO' => [
                'Global' => [
                    'Balanced' => 'Anda seimbang dalam melihat gambaran besar dan detail langkah demi langkah',
                    'Moderate' => 'Anda cukup nyaman memahami konsep secara keseluruhan terlebih dahulu',
                    'Strong' => 'Anda sangat suka memahami gambaran besar sebelum fokus pada detail',
                ],
            ],
        ];

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'title' => $course->full_name,
            'content' => "learning_styles_combined.topik$topik.reflective_sensing_verbal_global.index",
            'course' => $course,
            'section' => $section,
            'scores'     => $scores,
            'descriptions' => $descriptions,

            // Reflective
            'reflective_files' => $reflectiveFiles,
            'reflective_images' => $imageFiles,
            'reflective_videos' => $videoFiles,
            'assignments' => $assignments,
            'forums' => $forum,
            'quiz' => $quiz,
            'page_files_reflective' => $pageFilesReflective,

            // Sensing
            'sensing_materials' => $sensingMaterials,
            'sensing_files' => $sensingFiles,
            'sensing_image' => $sensingImage,
            'sensing_video' => $sensingVideo,
            'sensing_assignments' => $sensingAssignments,
            'sensing_forums' => $sensingForum,
            'quiz_sensings' => $sensingQuiz,
            'page_files_sensing' => $pageFilesSensing,

            // Verbal
            'verbal_material' => $verbalMaterial,
            'youtube_videos' => $youtubeVideos,
            'verbal_images' => $verbalImages,
            'verbal_pdfs' => $verbalPdfs,
            'verbal_assignments' => $verbalAssignments,
            'verbal_forums' => $verbalForums,
            'quiz_verbal' => $verbalQuiz,
            'page_files_verbal' => $pageFilesVerbal,

            // Global
            'global_material' => $globalMaterial,
            'global_pdfs' => $globalPdfs,
            'global_video' => $globalVideo,
            'global_image' => $globalImage,
            'global_assignment' => $globalAssignments,
            'global_forums' => $globalForum,
            'quiz_global' => $globalQuiz,
            'quiz_attempt' => $quiz_attempt,
            'quiz_grade' => $quiz_grade,
            'page_files_global' => $pageFilesGlobal,
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
