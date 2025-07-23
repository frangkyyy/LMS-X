<?php

namespace App\Http\Controllers;


use App\Models\MDLInfografis;
use Illuminate\Support\Facades\DB;
use App\Models\MDLAssign;
use App\Models\MDLCourse;
use App\Models\MDLFiles;
use App\Models\MDLUrl;
use App\Models\MDLFolder;
use App\Models\MDLLabel;
use App\Models\MDLLesson;
use App\Models\MDLForum;
use App\Models\MDLPage;
use App\Models\MDLGlobal;
use App\Models\MDLIntuitive;
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

class ReflectiveIntuitiveVerbalGlobalController extends Controller
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

        // Ambil data section dengan sub-topiknya
        $section = MDLSection::with('sub_topic')->find($section_id);
        if (!$section) {
            abort(404, "Section dengan ID $section_id tidak ditemukan.");
        }

        // Gaya Belajar Reflective
        $reflectiveAssignments = MDLAssign::where('learning_style_id', 4)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $reflectiveForum = MDLForum::where('learning_style_id', 4)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->with(['posts.user'])
            ->get();

        $reflectiveLesson = MDLLesson::where('learning_style_id', 4)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $reflectiveQuiz = MDLQuiz::where('mdl_learning_style_id', 4)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        // Gaya Belajar Intuitive
        $intuitiveMaterial = MDLIntuitive::where('course_id', $course->id)
            ->where('section_id', $section_id)
            ->get();

        $intuitivePage = MDLPage::where('learning_style_id', 6)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $intuitiveFiles = MDLFiles::where('learning_style_id', 6)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $intuitiveFolder = MDLFolder::where('learning_style_id', 6)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $intuitiveUrl = MDLUrl::where('mdl_learning_style_id', 6)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        // Gaya Belajar Verbal
        $verbalMaterial = MDLVerbal::where('course_id', $course_id)->first();

        $verbalLabel = MDLLabel::where('learning_style_id', 2)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $verbalFiles = MDLFiles::where('learning_style_id', 2)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $verbalFolder = MDLFolder::where('learning_style_id', 2)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $verbalUrl = MDLUrl::where('mdl_learning_style_id', 2)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        // Gaya Belajar Global
        $globalMaterial = MDLGlobal::where('course_id', $course_id)->first();

        $globalFiles = MDLFiles::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalFolder = MDLFolder::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalPage = MDLPage::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalLabel = MDLLabel::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalUrl = MDLUrl::where('mdl_learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalAssignments = MDLAssign::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalForum = MDLForum::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->with(['posts.user'])
            ->get();

        $globalLesson = MDLLesson::where('learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        $globalQuiz = MDLQuiz::where('mdl_learning_style_id', 8)
            ->whereIn('sub_topic_id', $section->sub_topic->pluck('id'))
            ->get();

        // Ambil data gaya belajar
        $learningStyles = MDLUserLearningStyles::where('user_id', $user->id)->get();

        $dimensionLabels = [
            'ACT/REF' => ['Active', 'Reflective'],
            'SNS/INT' => ['Sensing', 'Intuitive'],
            'VIS/VRB' => ['Visual', 'Verbal'],
            'SEQ/GLO' => ['Sequential', 'Global'],
        ];

        $scores = [];
        if ($learningStyles->isNotEmpty()) {
            foreach ($learningStyles as $style) {
                $dimension = $style->dimension;
                $label = $style->final_score && preg_match('/[A-Za-z]+$/', $style->final_score, $matches)
                    ? $matches[0]
                    : ($dimensionLabels[$dimension][0] ?? 'Unknown');

                $scores[$dimension] = [
                    'label' => $label,
                    'category' => $style->category ?? 'Balanced',
                ];
            }
        }

        $descriptions = [
            'ACT/REF' => [
                'Reflective' => [
                    'Balanced' => 'Anda seimbang dalam belajar mandiri dan diskusi',
                    'Moderate' => 'Anda cukup suka belajar melalui refleksi dan berpikir',
                    'Strong' => 'Anda sangat suka belajar mandiri melalui refleksi sebelum bertindak',
                ],
                'Active' => [
                    'Balanced' => 'Anda seimbang dalam belajar mandiri dan diskusi',
                    'Moderate' => 'Anda cukup suka belajar melalui aktivitas dan kolaborasi',
                    'Strong' => 'Anda sangat suka belajar melalui aktivitas dan interaksi',
                ],
            ],
            'SNS/INT' => [
                'Intuitive' => [
                    'Balanced' => 'Anda seimbang antara memahami fakta konkret dan teori abstrak',
                    'Moderate' => 'Anda cukup nyaman dengan konsep abstrak dan ide-ide',
                    'Strong' => 'Anda sangat suka belajar melalui konsep abstrak dan teori',
                ],
                'Sensing' => [
                    'Balanced' => 'Anda seimbang antara memahami fakta konkret dan teori abstrak',
                    'Moderate' => 'Anda cukup nyaman dengan fakta konkret dan detail praktis',
                    'Strong' => 'Anda sangat suka belajar melalui fakta konkret dan aplikasi praktis',
                ],
            ],
            'VIS/VRB' => [
                'Verbal' => [
                    'Balanced' => 'Anda seimbang dalam memahami informasi visual dan verbal',
                    'Moderate' => 'Anda cukup nyaman memahami melalui penjelasan lisan atau tulisan',
                    'Strong' => 'Anda sangat nyaman belajar lewat bacaan dan penjelasan lisan',
                ],
                'Visual' => [
                    'Balanced' => 'Anda seimbang dalam memahami informasi visual dan verbal',
                    'Moderate' => 'Anda cukup nyaman memahami melalui gambar dan diagram',
                    'Strong' => 'Anda sangat nyaman belajar lewat visualisasi dan gambar',
                ],
            ],
            'SEQ/GLO' => [
                'Global' => [
                    'Balanced' => 'Anda seimbang dalam memahami gambaran besar dan langkah-langkah detail',
                    'Moderate' => 'Anda cukup nyaman memahami konsep besar sebelum rincian',
                    'Strong' => 'Anda sangat suka memahami gambaran besar sebelum fokus ke detail',
                ],
                'Sequential' => [
                    'Balanced' => 'Anda seimbang dalam memahami gambaran besar dan langkah-langkah detail',
                    'Moderate' => 'Anda cukup nyaman memahami langkah-langkah secara berurutan',
                    'Strong' => 'Anda sangat suka memahami detail secara berurutan sebelum gambaran besar',
                ],
            ],
        ];

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'title' => $course->full_name,
            'content' => "learning_styles_combined.topik$topik.reflective_intuitive_verbal_global.index",
            'course' => $course,
            'section' => $section,
//            'sensing_materials' => $sensingMaterials,
            'scores' => $scores,
            'descriptions' => $descriptions,

            // Reflective
            'reflectiveAssignments' => $reflectiveAssignments,
            'reflectiveForum' => $reflectiveForum,
            'reflectiveLesson' => $reflectiveLesson,
            'reflectiveQuiz' => $reflectiveQuiz,

            // Intuitive
            'intuitive_materials' => $intuitiveMaterial,
            'intuitivePage' => $intuitivePage,
            'intuitiveFiles' => $intuitiveFiles,
            'intuitiveFolder' => $intuitiveFolder,
            'intuitiveUrl' => $intuitiveUrl,

            // Verbal
            'verbalLabel' => $verbalLabel,
            'verbalFiles' => $verbalFiles,
            'verbalFolder' => $verbalFolder,
            'verbalUrl' => $verbalUrl,

            // Global
            'globalFiles' => $globalFiles,
            'globalFolder' => $globalFolder,
            'globalLabel' => $globalLabel,
            'globalPage' => $globalPage,
            'globalUrl' => $globalUrl,
            'globalAssignments' => $globalAssignments,
            'globalLesson' => $globalLesson,
            'globalForum' => $globalForum,
            'globalQuiz' => $globalQuiz,
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
