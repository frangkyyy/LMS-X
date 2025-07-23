<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MDLSection;
use App\Models\MDLCourse;
use App\Models\CourseSubtopik;
use App\Models\MDLQuiz;
use Illuminate\Support\Facades\Log;

use App\Models\MDLQuizAttempts;
use App\Models\DimensionOption;
use App\Models\MDLUserLearningStyles;
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
        // Ambil data pengguna dan gaya belajar
        $user = Auth::user()->load('learning_style');
        $userId = $user->id;
        Log::info('Memulai showtopikmahasiswa untuk user_id: ' . $userId . ', course_id: ' . $course_id . ', section_id: ' . $section_id . ' pada ' . now()->format('d-m-Y H:i:s'));

        // Validasi gaya belajar pengguna
        $userLearningStyles = MDLUserLearningStyles::where('user_id', $userId)->get();
        if ($userLearningStyles->isEmpty()) {
            Log::error('User ' . $userId . ' tidak memiliki gaya belajar di mdl_user_learning_styles.');
            return redirect()->back()->with('error', 'User tidak memiliki gaya belajar yang terkait. Silakan atur gaya belajar terlebih dahulu.');
        }

        // Tentukan pasangan gaya belajar berlawanan
        $oppositeStyles = [
            1 => 2, 2 => 1, // Visual <-> Verbal
            3 => 4, 4 => 3, // Active <-> Reflective
            5 => 6, 6 => 5, // Sensing <-> Intuitive
            7 => 8, 8 => 7  // Sequential <-> Global
        ];

        // Pemetaan dimensi ke opsi dimensi
        $dimensionToOptions = [
            1 => [3, 4], // Processing: Active, Reflective
            2 => [5, 6], // Perception: Sensing, Intuitive
            3 => [1, 2], // Input: Visual, Verbal
            4 => [7, 8], // Understanding: Sequential, Global
        ];

        // Pisahkan gaya belajar berdasarkan kategori
        $strongStyles = $userLearningStyles->where('category', 'Strong')->pluck('learning_style_id')->toArray();
        $moderateStyles = $userLearningStyles->where('category', 'Moderate')->pluck('learning_style_id')->toArray();
        $balancedStyles = $userLearningStyles->where('category', 'Balanced')->pluck('learning_style_id')->toArray();

        // Inisialisasi ID gaya belajar yang diizinkan
        $originalAllowedLearningStyleIds = array_merge(
            $strongStyles,
            $moderateStyles,
            $balancedStyles
        );

        // Untuk Balanced, tambahkan juga gaya belajar lawannya
        foreach ($balancedStyles as $styleId) {
            if (isset($oppositeStyles[$styleId])) {
                $originalAllowedLearningStyleIds[] = $oppositeStyles[$styleId];
            }
        }
        $originalAllowedLearningStyleIds = array_unique($originalAllowedLearningStyleIds);

        // Validasi kursus
        $course = MDLCourse::where('id', $course_id)->first();
        if (!$course) {
            Log::error('Kursus dengan ID ' . $course_id . ' tidak ditemukan.');
            return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
        }

        // Ambil section dengan relasi subtopik dan sumber daya
        $section = MDLSection::with([
            'sub_topic' => function ($query) {
                $query->orderBy('sortorder', 'asc')->with([
                    'labels.options',
                    'forums.options',
                    'pages.options',
                    'assignments.options',
                    'quizs.dimensions',
                    'files.options',
                    'folders.options',
                    'lessons.options',
                    'urls.options',
                    'infografis.options',
                ]);
            },
            'referensi'
        ])
            ->where('id', $section_id)
            ->where('course_id', $course_id)
            ->first();

        if (!$section) {
            Log::error('Section dengan ID ' . $section_id . ' untuk course_id ' . $course_id . ' tidak ditemukan.');
            return redirect()->back()->with('error', 'Section tidak ditemukan.');
        }

        // Ambil semua subtopik untuk section
        $allSubTopics = CourseSubtopik::where('section_id', $section_id)
            ->orderBy('sortorder', 'asc')
            ->get();

        // Variabel untuk menyimpan gaya belajar yang digunakan di subtopik sebelumnya (hanya untuk Moderate)
        $previousModerateStyles = null;
        $previousFailedAllQuizzes = false;

        // Proses setiap subtopik
        foreach ($section->sub_topic as $subTopic) {
            $newAllowedStyleIds = $originalAllowedLearningStyleIds; // Mulai dengan gaya belajar asli
            $isFirstSubTopic = $allSubTopics->where('sortorder', $allSubTopics->min('sortorder'))->first()->id == $subTopic->id;

            // Penyesuaian gaya belajar hanya untuk Moderate
            if (!$isFirstSubTopic && !empty($moderateStyles)) {
                $previousSubTopic = $allSubTopics->where('sortorder', '<', $subTopic->sortorder)
                    ->sortByDesc('sortorder')
                    ->first();

                if ($previousSubTopic) {
                    $previousQuizzes = MDLQuiz::where('sub_topic_id', $previousSubTopic->id)
                        ->with('dimensions')
                        ->get();

                    if ($previousQuizzes->count() >= 3) {
                        // Buat daftar dimensi yang gagal
                        $failedDimensions = [];
                        foreach ($previousQuizzes as $quiz) {
                            $highestAttempt = MDLQuizAttempts::where('quiz_id', $quiz->id)
                                ->where('user_id', $userId)
                                ->orderBy('score', 'desc')
                                ->first();

                            $dimensionId = $quiz->learning_style_id;
                            if ($dimensionId && $highestAttempt) {
                                $highestScore = $highestAttempt->score;
                                $passingGrade = $quiz->grade_to_pass ?? 0;

                                if ($highestScore < $passingGrade) {
                                    $failedDimensions[] = $dimensionId;
                                }
                            }
                        }

                        // Cek apakah semua kuis gagal
                        $previousFailedAllQuizzes = count($failedDimensions) >= 3;

                        // Jika semua kuis gagal dan ada gaya belajar Moderate sebelumnya
                        if ($previousFailedAllQuizzes && $previousModerateStyles) {
                            $newModerateStyles = [];
                            foreach ($previousModerateStyles as $styleId) {
                                if (isset($oppositeStyles[$styleId])) {
                                    $newModerateStyles[] = $oppositeStyles[$styleId];
                                } else {
                                    $newModerateStyles[] = $styleId;
                                }
                            }
                            $newModerateStyles = array_unique($newModerateStyles);

                            // Gabungkan dengan gaya belajar Strong dan Balanced
                            $newAllowedStyleIds = array_merge(
                                $strongStyles,
                                $newModerateStyles,
                                $balancedStyles
                            );

                            // Untuk Balanced, tambahkan juga gaya belajar lawannya
                            foreach ($balancedStyles as $styleId) {
                                if (isset($oppositeStyles[$styleId])) {
                                    $newAllowedStyleIds[] = $oppositeStyles[$styleId];
                                }
                            }
                            $newAllowedStyleIds = array_unique($newAllowedStyleIds);

                            Log::info("Semua kuis gagal di subtopik sebelumnya. Menggunakan gaya belajar lawan untuk Moderate: ", $newModerateStyles);
                        }
                    }
                }
            }

            // Simpan gaya belajar Moderate yang digunakan untuk subtopik ini
            $previousModerateStyles = array_intersect($newAllowedStyleIds, $moderateStyles);

            // Log gaya belajar yang digunakan
            Log::info("Gaya belajar yang diizinkan untuk subtopik {$subTopic->id}: ", $newAllowedStyleIds);

            // Filter sumber daya lain berdasarkan gaya belajar
            $subTopic->labels = $subTopic->labels()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->forums = $subTopic->forums()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->pages = $subTopic->pages()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->assignments = $subTopic->assignments()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->files = $subTopic->files()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->folders = $subTopic->folders()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->lessons = $subTopic->lessons()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->urls = $subTopic->urls()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();
            $subTopic->infografis = $subTopic->infografis()->whereHas('options', function ($q) use ($newAllowedStyleIds) {
                $q->whereIn('opsi_dimensi.id', $newAllowedStyleIds);
            })->get();

            // Ambil semua kuis tanpa filter
            $subTopic->quizs = $subTopic->quizs()->get();
            Log::info("Kuis untuk subtopik {$subTopic->id}: ", $subTopic->quizs->pluck('id', 'name')->toArray());

            // Gabungkan semua item
            $items = collect([])
                ->merge($subTopic->labels)
                ->merge($subTopic->files)
                ->merge($subTopic->infografis)
                ->merge($subTopic->assignments)
                ->merge($subTopic->forums)
                ->merge($subTopic->lessons)
                ->merge($subTopic->urls)
                ->merge($subTopic->folders)
                ->merge($subTopic->pages)
                ->merge($subTopic->quizs)
                ->sortBy('created_at')
                ->values();

            $subTopic->sorted_items = $items;
        }

        // Ambil semua section untuk indeks
        $sections = MDLSection::where('course_id', $course_id)
            ->where('visible', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $indeks = $sections->search(function ($item) use ($section) {
                return $item->id == $section->id;
            }) + 1;

        // Determine view based on user's primary learning style in Sequential/Global dimension
        $isSequential = $userLearningStyles->contains(function ($style) {
            return $style->learning_style_id === 7; // Sequential
        });

        // Siapkan data untuk view
        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => $isSequential ? 'course.sectionShowMahasiswa' : 'course.sectionGlobalShowMahasiswa',
            'indeks' => $indeks,
            'title' => $section->title,
            'course' => $course,
            'section' => $section,
        ];

        return view('layouts.v_template', $data);
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
