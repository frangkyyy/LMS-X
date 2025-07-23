<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MDLQuiz;
use App\Models\MDLCourse;
use App\Models\MDLActive;
use App\Models\MDLForum;
use App\Models\MDLFiles;
use App\Models\MDLQuizQuestion;
use App\Models\MDLSequential;
use App\Models\MDLGlobal;
use App\Models\MDLQuizAttempts;
use App\Models\MDLQuizGrades;
use App\Models\MDLQuizAnswer;
use App\Models\MDLPage;
use App\Models\CourseSubtopik;

use App\Models\DimensionOption;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;


class MDLQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index($course_id)
    // {
    //     $course = MDLCourse::find($course_id);
    //     if (!$course) {
    //         abort(404, "Course dengan ID $course_id tidak ditemukan.");
    //     }

    //     $sections = MDLActive::where('course_id', $course->id)->get();

    //     // Ambil video berdasarkan content_id jika ada
    //     $video = MDLActive::where('course_id', $course->id)
    //         ->where('content_type', 'video')
    //         ->first();

    //     $forum = MDLForum::with('posts.user')
    //         ->where('course_id', $course->id)
    //         ->first();

    //     // Cari URL video berdasarkan content_id di tabel mdl_files
    //     $video_url = null;
    //     if ($video && $video->file_id) {
    //         $video_file = MDLFiles::where('id', $video->file_id)->first();
    //         $video_url = $video_file ? $video_file->file_path : null;
    //     }

    //     // Ambil quiz dan soal-soalnya
    //     $quiz = MDLQuiz::where('course_id', $course->id)
    //         ->where('name', 'Pengantar IoT')
    //         ->first();

    //     $questions = $quiz
    //         ? MDLQuizQuestion::where('quiz_id', $quiz->id)
    //             ->where('learning_style', 'active')
    //             ->get()
    //         : collect(); // kosong jika quiz tidak ada

    //     return view('layouts.v_template', [
    //         'menu' => 'menu.v_menu_admin',
    //         'content' => 'quiz.show',
    //         'title' => 'Quiz: Pengantar IoT',
    //         'course' => $course,
    //         'sections' => $sections,
    //         'forum' => $forum,
    //         'video_url' => $video_url,
    //         'quiz' => $quiz,
    //         'questions' => $questions,
    //     ]);
    // }

    // public function showQuiz($quiz_id)
    // {
    //     $quiz = MDLQuiz::findOrFail($quiz_id);
    //     $course = MDLCourse::find($quiz->course_id);

    //     // Get sections based on the quiz's learning style
    //     if ($quiz->learning_style === 'sequential') {
    //         $sections = MDLSequential::where('course_id', $course->id)->get();
    //     } elseif ($quiz->learning_style === 'global') {
    //         $sections = MDLGlobal::where('course_id', $course->id)->get();
    //     } else {
    //         $sections = MDLActive::where('course_id', $course->id)->get();
    //     }

    //     // Get questions that match the quiz's learning style and topic
    //     $questions = MDLQuizQuestion::where('quiz_id', $quiz_id)
    //         ->when($quiz->learning_style, function($query, $learningStyle) {
    //             return $query->where('learning_style', $learningStyle);
    //         })
    //         ->when($quiz->topik, function($query, $topik) {
    //             return $query->where('topik', $topik);
    //         })
    //         ->get();

    //     // Check if user has attempts left
    //     $attempts = MDLQuizAttempts::where('quiz_id', $quiz_id)
    //         ->where('user_id', Auth::id())
    //         ->count();

    //     $canAttempt = true;
    //     if ($quiz->max_attempts > 0 && $attempts >= $quiz->max_attempts) {
    //         $canAttempt = false;
    //     }

    //     // Check time constraints
    //     $now = Carbon::now();
    //     if ($quiz->time_open && $now < $quiz->time_open) {
    //         $canAttempt = false;
    //     }
    //     if ($quiz->time_close && $now > $quiz->time_close) {
    //         $canAttempt = false;
    //     }

    //     return view('layouts.v_template', [
    //         'menu' => 'menu.v_menu_admin',
    //         'content' => 'quiz.show_questions',
    //         'title' => 'Quiz: ' . $quiz->name,
    //         'course' => $course,
    //         'sections' => $sections,
    //         'quiz' => $quiz,
    //         'questions' => $questions,
    //         'canAttempt' => $canAttempt,
    //         'attemptsCount' => $attempts,
    //         'maxAttempts' => $quiz->max_attempts,
    //     ]);
    // }

    public function showMahasiswa($id)
    {
        $quiz = MDLQuiz::with(['questions', 'attempts' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->findOrFail($id);

        $subTopic = $quiz->sub_topic;
        $section = $subTopic->section;
        $course = $section->course;
        if ($quiz->time_open > now() || $quiz->time_close < now()) {
            return redirect()->route('dashboard2')->with('error', 'This quiz is not available.');
        }

        // Cek apakah jumlah percobaan sudah mencapai batas maksimum
        if ($quiz->attempts->count() >= $quiz->max_attempts) {
            // Ambil percobaan terakhir pengguna
            $lastAttempt = $quiz->attempts->sortByDesc('created_at')->first();
            if ($lastAttempt) {
                // Arahkan ke halaman hasil dengan ID kuis dan ID percobaan
                return redirect()->route('quiz.result', [$quiz->id, $lastAttempt->id])
                    ->with('status', 'You have reached the maximum number of attempts. Here are your results.');
            }
            // Jika tidak ada percobaan (kasus edge), arahkan ke dashboard
            return redirect()->route('dashboard2')->with('error', 'No attempts found for this quiz.');
        }
        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.qestions_mahasiswa',
            'quiz'=> $quiz,
            'title' => $section->title,
            'course' => $course,
            'section' => $section,
            'subTopic' => $subTopic ,
        ];

        return view('layouts.v_template',$data);

        // return view('quiz.qestions_mahasiswa', compact('quiz'));
    }

    public function submit(Request $request, $quizId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengirimkan kuis.');
        }
        $quiz = MDLQuiz::with('questions')->findOrFail($quizId);
        $userId = Auth::id();

        // Cek batas percobaan
        $attemptCount = $quiz->attempts()->where('user_id', $userId)->count();
        if ($attemptCount >= $quiz->max_attempts) {
            return redirect()->back()->with('error', 'Anda telah mencapai batas maksimum percobaan.');
        }

        // Buat entri baru di MDLQuizAttempts
        $attempt = MDLQuizAttempts::create([
            'quiz_id' => $quiz->id,
            'user_id' => $userId,
            'attempt_number' => $attemptCount + 1,
            'created_at' => now(),
        ]);

        // Simpan jawaban dan hitung poin
        $answers = $request->input('answers', []);
        $totalScore = 0;

        foreach ($answers as $questionId => $answer) {
            $question = $quiz->questions->firstWhere('id', $questionId);
            if ($question) {
                // Bandingkan jawaban mahasiswa dengan correct_answer
                $poin = ($answer === $question->correct_answer) ? $question->poin : 0;

                MDLQuizAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $questionId,
                    'user_id' => $userId,
                    'answer' => $answer,
                    'poin' => $poin,
                ]);
                $totalScore += $poin;

            }
        }
        $attempt->update(['score' => $totalScore]);
        return response()->json([
            'redirect_url' => route('quiz.result', [$quiz->id, $attempt->id]),
            'attempt_id' => $attempt->id,
            'success' => 'Jawaban kuis telah berhasil dikirim!'
        ]);
    }



    public function submitQuiz(Request $request, $quiz_id)
    {
        $quiz = MDLQuiz::findOrFail($quiz_id);
        $user = Auth::user();

        // Check attempts
        $attempts = MDLQuizAttempts::where('quiz_id', $quiz_id)
            ->where('user_id', $user->id)
            ->count();

        if ($quiz->max_attempts > 0 && $attempts >= $quiz->max_attempts) {
            return redirect()->back()->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Check time constraints
        $now = Carbon::now();
        if ($quiz->time_open && $now < $quiz->time_open) {
            return redirect()->back()->with('error', 'This quiz is not yet available.');
        }
        if ($quiz->time_close && $now > $quiz->time_close) {
            return redirect()->back()->with('error', 'The time for this quiz has expired.');
        }

        // Create quiz attempt
        $attemptNumber = $attempts + 1;
        $attempt = MDLQuizAttempts::create([
            'quiz_id' => $quiz_id,
            'user_id' => Auth::id(),
            'attempt' => $attemptNumber,
            'start_time' => now(),
            'end_time' => now()
        ]);

        // Calculate score
        $questions = MDLQuizQuestion::where('quiz_id', $quiz_id)
            ->when($quiz->learning_style, function($query, $learningStyle) {
                return $query->where('learning_style', $learningStyle);
            })
            ->when($quiz->topik, function($query, $topik) {
                return $query->where('topik', $topik);
            })
            ->get();

        $totalQuestions = $questions->count();
        $correctAnswers = 0;

        foreach ($questions as $question) {
            $userAnswer = $request->input('question_'.$question->id);

            // Store each answer in mdl_quiz_answers
            if ($userAnswer) {
                MDLQuizAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'answer' => $userAnswer
                ]);
            }

            if ($userAnswer === $question->correct_answer) {
                $correctAnswers++;
            }
        }

        $grade = ($correctAnswers / $totalQuestions) * 100;

        // Save grade
        MDLQuizGrades::create([
            'attempt_id' => $attempt->id,
            'quiz_id' => $quiz_id,
            'user_id' => Auth::id(),
            'grade' => $grade,
            'attempt_number' => $attempt->attempt,
            'completed_at' => now()
        ]);

        // Update attempt with score
        $attempt->update(['score' => $grade]);

        return redirect()->route('quiz.results', $quiz_id)
            ->with('success', 'Quiz submitted successfully! Your score: '.round($grade, 2).'%');
    }

    public function showResults($quiz_id)
    {
        $quiz = MDLQuiz::findOrFail($quiz_id);

        $grades = MDLQuizGrades::with('attempt')
            ->where('quiz_id', $quiz_id)
            ->where('user_id', Auth::id())
            ->orderBy('attempt_number', 'desc')
            ->get();

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.results',
            'title' => 'Quiz Results: ' . $quiz->name,
            'quiz' => $quiz,
            'grades' => $grades,
        ]);
    }

    // public function showAttemptDetails($quiz_id, $attempt_id)
    // {
    //     $attempt = MDLQuizAttempts::with(['quiz', 'grade', 'answers'])
    //         ->where('id', $attempt_id)
    //         ->where('quiz_id', $quiz_id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();

    //     $questions = MDLQuizQuestion::where('quiz_id', $quiz_id)->get();

    //     return view('layouts.v_template', [
    //         'menu' => 'menu.v_menu_admin',
    //         'content' => 'quiz.attempt_details',
    //         'attempt' => $attempt,
    //         'quiz' => $attempt->quiz,
    //         'grade' => $attempt->grade,
    //         'questions' => $questions
    //     ]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function showSequentialQuiz($course_id)
    // {
    //     $course = MDLCourse::findOrFail($course_id);
    //     $sections = MDLSequential::where('course_id', $course->id)->get();

    //     $quiz = MDLQuiz::where('course_id', $course->id)
    //         ->where('learning_style', 'sequential')
    //         ->first();

    //     $questions = $quiz ? MDLQuizQuestion::where('quiz_id', $quiz->id)
    //         ->where('learning_style', 'sequential')
    //         ->get() : collect();

    //     return view('layouts.v_template', [
    //         'menu' => 'menu.v_menu_admin',
    //         'content' => 'quiz.show_sequential',
    //         'title' => 'Quiz: ' . ($quiz ? $quiz->name : 'Sequential Quiz'),
    //         'course' => $course,
    //         'sections' => $sections,
    //         'quiz' => $quiz,
    //         'questions' => $questions,
    //     ]);
    // }

    // public function showGlobalQuiz($course_id)
    // {
    //     $course = MDLCourse::findOrFail($course_id);
    //     $sections = MDLGlobal::where('course_id', $course->id)->get();

    //     $quiz = MDLQuiz::where('course_id', $course->id)
    //         ->where('learning_style', 'global')
    //         ->first();

    //     $questions = $quiz ? MDLQuizQuestion::where('quiz_id', $quiz->id)
    //         ->where('learning_style', 'global')
    //         ->get() : collect();

    //     return view('layouts.v_template', [
    //         'menu' => 'menu.v_menu_admin',
    //         'content' => 'quiz.show_global',
    //         'title' => 'Quiz: ' . ($quiz ? $quiz->name : 'Global Quiz'),
    //         'course' => $course,
    //         'sections' => $sections,
    //         'quiz' => $quiz,
    //         'questions' => $questions,
    //     ]);
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create(Request $request)
    {
        $subTopicId = $request->query('sub_topic_id');

        // Ambil sub-topik spesifik berdasarkan sub_topic_id
        $subTopic = CourseSubtopik::findOrFail($subTopicId);
        $learningStyles = DimensionOption::all();
        $subTopics = CourseSubtopik::all();
        return view('quiz.create', compact('learningStyles', 'subTopics','subTopic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',

                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'learning_style_id' => 'required|exists:opsi_dimensi,id',
                'time_open' => 'nullable|date',
                'time_close' => 'nullable|date|after:time_open',
                'time_limit' => 'nullable|integer|min:0',
                'max_attempts' => 'nullable|integer|min:1',
                'grade_to_pass' => 'nullable|numeric|min:0|max:100',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            MDLQuiz::create([
                'name' => $validated['name'],
                'description' => $validated['description'],

                'sub_topic_id' => $validated['sub_topic_id'],
                'mdl_learning_style_id' => $validated['learning_style_id'],
                'time_open' => $validated['time_open'],
                'time_close' => $validated['time_close'],
                'time_limit' => $validated['time_limit'],
                'max_attempts' => $validated['max_attempts'],
                'grade_to_pass' => $validated['grade_to_pass'],
            ]);

            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Quiz berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan quiz: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $quiz = MDLQuiz::with(['sub_topic.section.course', 'learning_style'])->findOrFail($id);
            $subTopic = $quiz->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;


            $data = [
                'menu' => 'menu.v_menu_admin',
                'content' => 'quiz.quiz_show',
                'title' => $quiz->name, //
                'quiz' => $quiz,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
            ];

            return view('layouts.v_template', $data);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menampilkan halaman: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLQuiz $mDLQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLQuiz $mDLQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLQuiz $mDLQuiz)
    {
        //
    }



    public function result($quizId, $attemptId)
    {
        //$quiz = MDLQuiz::findOrFail($quizId);
        $attempt = MDLQuizAttempts::with('answers.question')->findOrFail($attemptId);
        $quiz = MDLQuiz::with(['sub_topic.section.course', 'learning_style'])->findOrFail($quizId);
        $subTopic = $quiz->sub_topic;
        $section = $subTopic->section;
        $course = $section->course;

        $totalPoin = $attempt->answers->sum('poin');

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.quiz_result',

            'course' => $course,
            'section' => $section,
            'subTopic' => $subTopic,

            'quiz' => $quiz,
            'attempt' => $attempt,
            'totalPoin' => $totalPoin,
        ];

        return view('layouts.v_template',$data);

        //return view('quiz.quiz_result', compact('quiz', 'attempt', 'totalPoin'));
    }

}
