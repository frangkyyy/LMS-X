<?php

namespace App\Http\Controllers;

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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MDLQuizController extends Controller
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

        $sections = MDLActive::where('course_id', $course->id)->get();

        // Ambil video berdasarkan content_id jika ada
        $video = MDLActive::where('course_id', $course->id)
            ->where('content_type', 'video')
            ->first();

        $forum = MDLForum::with('posts.user')
            ->where('course_id', $course->id)
            ->first();

        // Cari URL video berdasarkan content_id di tabel mdl_files
        $video_url = null;
        if ($video && $video->file_id) {
            $video_file = MDLFiles::where('id', $video->file_id)->first();
            $video_url = $video_file ? $video_file->file_path : null;
        }

        // Ambil quiz dan soal-soalnya
        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('name', 'Pengantar IoT')
            ->first();

        $questions = $quiz
            ? MDLQuizQuestion::where('quiz_id', $quiz->id)
                ->where('learning_style', 'active')
                ->get()
            : collect(); // kosong jika quiz tidak ada

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.show',
            'title' => 'Quiz: Pengantar IoT',
            'course' => $course,
            'sections' => $sections,
            'forum' => $forum,
            'video_url' => $video_url,
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }

    public function showQuiz($quiz_id)
    {
        $quiz = MDLQuiz::findOrFail($quiz_id);
        $course = MDLCourse::find($quiz->course_id);

        // Get sections based on the quiz's learning style
        if ($quiz->learning_style === 'sequential') {
            $sections = MDLSequential::where('course_id', $course->id)->get();
        } elseif ($quiz->learning_style === 'global') {
            $sections = MDLGlobal::where('course_id', $course->id)->get();
        } else {
            $sections = MDLActive::where('course_id', $course->id)->get();
        }

        // Get questions that match the quiz's learning style and topic
        $questions = MDLQuizQuestion::where('quiz_id', $quiz_id)
            ->when($quiz->learning_style, function($query, $learningStyle) {
                return $query->where('learning_style', $learningStyle);
            })
            ->when($quiz->topik, function($query, $topik) {
                return $query->where('topik', $topik);
            })
            ->get();

        // Check if user has attempts left
        $attempts = MDLQuizAttempts::where('quiz_id', $quiz_id)
            ->where('user_id', Auth::id())
            ->count();

        $canAttempt = true;
        if ($quiz->max_attempts > 0 && $attempts >= $quiz->max_attempts) {
            $canAttempt = false;
        }

        // Check time constraints
        $now = Carbon::now();
        if ($quiz->time_open && $now < $quiz->time_open) {
            $canAttempt = false;
        }
        if ($quiz->time_close && $now > $quiz->time_close) {
            $canAttempt = false;
        }

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.show_questions',
            'title' => 'Quiz: ' . $quiz->name,
            'course' => $course,
            'sections' => $sections,
            'quiz' => $quiz,
            'questions' => $questions,
            'canAttempt' => $canAttempt,
            'attemptsCount' => $attempts,
            'maxAttempts' => $quiz->max_attempts,
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

    public function showAttemptDetails($quiz_id, $attempt_id)
    {
        $attempt = MDLQuizAttempts::with(['quiz', 'grade', 'answers'])
            ->where('id', $attempt_id)
            ->where('quiz_id', $quiz_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $questions = MDLQuizQuestion::where('quiz_id', $quiz_id)->get();

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.attempt_details',
            'attempt' => $attempt,
            'quiz' => $attempt->quiz,
            'grade' => $attempt->grade,
            'questions' => $questions
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSequentialQuiz($course_id)
    {
        $course = MDLCourse::findOrFail($course_id);
        $sections = MDLSequential::where('course_id', $course->id)->get();

        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'sequential')
            ->first();

        $questions = $quiz ? MDLQuizQuestion::where('quiz_id', $quiz->id)
            ->where('learning_style', 'sequential')
            ->get() : collect();

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.show_sequential',
            'title' => 'Quiz: ' . ($quiz ? $quiz->name : 'Sequential Quiz'),
            'course' => $course,
            'sections' => $sections,
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }

    public function showGlobalQuiz($course_id)
    {
        $course = MDLCourse::findOrFail($course_id);
        $sections = MDLGlobal::where('course_id', $course->id)->get();

        $quiz = MDLQuiz::where('course_id', $course->id)
            ->where('learning_style', 'global')
            ->first();

        $questions = $quiz ? MDLQuizQuestion::where('quiz_id', $quiz->id)
            ->where('learning_style', 'global')
            ->get() : collect();

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.show_global',
            'title' => 'Quiz: ' . ($quiz ? $quiz->name : 'Global Quiz'),
            'course' => $course,
            'sections' => $sections,
            'quiz' => $quiz,
            'questions' => $questions,
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
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(MDLQuiz $mDLQuiz)
    {
        //
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
}
