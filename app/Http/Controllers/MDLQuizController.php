<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MDLQuiz;
use App\Models\MDLCourse;
use App\Models\MDLActive;
use App\Models\MDLForum;
use App\Models\MDLFiles;
use App\Models\MDLQuizQuestion;
use App\Models\MDLLearningStyles;
use App\Models\MDLSequential;
use App\Models\MDLGlobal;
use App\Models\MDLQuizAttempts;
use App\Models\MDLQuizGrades;
use App\Models\MDLQuizAnswer;
use App\Models\MDLPage;
use App\Models\CourseSubtopik;
use App\Models\DimensionOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MDLQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create(Request $request)
    {
        $subTopicId = $request->query('sub_topic_id');

        // Ambil sub-topik spesifik berdasarkan sub_topic_id
        $subTopic = CourseSubtopik::findOrFail($subTopicId);
        $dimensions = MDLLearningStyles::with('options')->get();
        $subTopics = CourseSubtopik::all();
        return view('quiz.create', compact('dimensions', 'subTopics','subTopic'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            // Validate form inputs with custom error messages
            $validated = $request->validate([
                'sub_topic_id' => 'required|integer|exists:mdl_course_subtopik,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'learning_style_id' => 'required|integer|exists:mdl_learning_styles,id',
                'time_open' => 'nullable|date',
                'time_close' => 'nullable|date|after:time_open',
                'time_limit' => 'nullable|integer|min:0', // Input in minutes
                'max_attempts' => 'required|integer|min:1',
                'grade_to_pass' => 'required|numeric|min:0|max:100',
                'action' => 'required|in:save_return,save_display',
            ], [
                'sub_topic_id.exists' => 'The selected sub-topic is invalid.',
                'name.required' => 'Please provide a quiz name.',
                'name.max' => 'The quiz name cannot exceed 255 characters.',
                'learning_style_id.required' => 'Please select a learning dimension.',
                'learning_style_id.exists' => 'The selected dimension is invalid.',
                'time_close.after' => 'The close time must be after the open time.',
                'time_limit.min' => 'The time limit cannot be negative.',
                'max_attempts.required' => 'Please specify the number of attempts.',
                'max_attempts.min' => 'At least one attempt is required.',
                'grade_to_pass.required' => 'Please specify the grade to pass.',
                'grade_to_pass.min' => 'The grade to pass cannot be negative.',
                'grade_to_pass.max' => 'The grade to pass cannot exceed 100.',
                'action.in' => 'Invalid action selected.',
            ]);

            // Check for duplicate dimension in sub-topic
            $existingQuiz = MDLQuiz::where('sub_topic_id', $validated['sub_topic_id'])
                ->where('learning_style_id', $validated['learning_style_id'])
                ->exists();
            if ($existingQuiz) {
                Log::warning('Attempt to create duplicate quiz for dimension', [
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'learning_style_id' => $validated['learning_style_id'],
                ]);
                return redirect()->back()
                    ->with('error', 'A quiz for this dimension (processing, input, or persepsi) already exists for this sub-topic.')
                    ->withInput();
            }

            // Convert time_limit from minutes to seconds
            $timeLimitInSeconds = $validated['time_limit'] ? $validated['time_limit'] * 60 : null;

            // Create quiz
            $quiz = MDLQuiz::create([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'time_open' => $validated['time_open'],
                'time_close' => $validated['time_close'],
                'time_limit' => $timeLimitInSeconds,
                'max_attempts' => $validated['max_attempts'],
                'grade_to_pass' => $validated['grade_to_pass'],
                'learning_style_id' => $validated['learning_style_id'],
            ]);

            Log::info('Quiz created successfully', [
                'quiz_id' => $quiz->id,
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'learning_style_id' => $validated['learning_style_id'],
                'time_limit_seconds' => $timeLimitInSeconds,
                'action' => $validated['action'],
            ]);
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            // Redirect based on action
            if ($validated['action'] === 'save_return') {
                return redirect()->route('sections.show', [$course_id, $section_id])


                    ->with('success', 'Quiz created successfully.');
            } else {
                return redirect()->route('quizs.show', $quiz->id)
                    ->with('success', 'Quiz created successfully.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for quiz submission', [
                'errors' => $e->errors(),
                'input' => $request->except('_token'),
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Please correct the errors below and try again.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error during quiz submission', [
                'message' => $e->getMessage(),
                'input' => $request->except('_token'),
            ]);
            return redirect()->back()
                ->with('error', 'An unexpected error occurred while creating the quiz. Please try again or contact support.')
                ->withInput();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
        try {
            // Log initial request details
            Log::info('Attempting to display quiz show page', [
                'quiz_id' => $id,
                'user_id' => Auth::id() ?? 'guest',
                'user_role' => Auth::user()->role ?? 'unknown',
                'request_path' => request()->path(),
                'referer' => request()->headers->get('referer') ?? 'none'
            ]);

            // Log quiz loading
            Log::debug('Loading quiz data for ID: ' . $id);
            $quiz = MDLQuiz::with(['sub_topic.section.course', 'attempts.user'])->findOrFail($id);
            Log::debug('Quiz loaded successfully', [
                'quiz_name' => $quiz->name,
                'sub_topic_id' => $quiz->sub_topic_id,
                'has_sub_topic' => !is_null($quiz->sub_topic)
            ]);

            // Extract and validate related data
            $subTopic = $quiz->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;

            if (is_null($subTopic) || is_null($section) || is_null($course)) {
                Log::warning('Missing related data for quiz', [
                    'quiz_id' => $id,
                    'sub_topic' => is_null($subTopic) ? 'null' : $subTopic->id,
                    'section' => is_null($section) ? 'null' : $section->id,
                    'course' => is_null($course) ? 'null' : $course->id
                ]);
            }

            // Log participant processing
            Log::debug('Processing participant attempts');
            $participants = $quiz->attempts
                ->groupBy('user_id')
                ->map(function ($attempts, $userId) {
                    $highestAttempt = $attempts->sortByDesc('score')->first();
                    Log::debug('Processed participant attempt', [
                        'user_id' => $userId,
                        'highest_score' => $highestAttempt->score,
                        'attempt_number' => $highestAttempt->attempt_number
                    ]);
                    return [
                        'user' => $highestAttempt->user,
                        'highest_score' => $highestAttempt->score,
                        'attempt_number' => $highestAttempt->attempt_number,
                        'start_time' => $highestAttempt->start_time,
                        'end_time' => $highestAttempt->end_time,
                    ];
                })->sortByDesc('highest_score')->values();

            Log::debug('Participants processed', ['participant_count' => $participants->count()]);

            // Log view rendering
            Log::info('Rendering quiz show view', [
                'quiz_id' => $id,
                'view' => 'layouts.v_template',
                'content_view' => 'quiz.quiz_show'
            ]);

            // Prepare and return view (non-logging code omitted for brevity)
            $data = [
                'menu' => 'menu.v_menu_admin',
                'content' => 'quiz.quiz_show',
                'title' => $quiz->name,
                'quiz' => $quiz,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
                'options' => $quiz->options,
                'participants' => $participants,
            ];

            return view('layouts.v_template', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log quiz not found error
            Log::error('Quiz not found', [
                'quiz_id' => $id,
                'user_id' => Auth::id() ?? 'guest',
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors(['error' => 'Quiz tidak ditemukan.']);
        } catch (\Exception $e) {
            // Log general error
            Log::error('Failed to display quiz show page', [
                'quiz_id' => $id,
                'user_id' => Auth::id() ?? 'guest',
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => request()->all()
            ]);
            return redirect()->back()->withErrors(['error' => 'Gagal menampilkan halaman: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */


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

    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit($quiz_id)
    {
        try {
            // Retrieve the quiz with its related sub-topic, section, course, and options
            $quiz = MDLQuiz::with(['sub_topic.section.course'])
                ->findOrFail($quiz_id);

            $dimensions = MDLLearningStyles::with('options')->get();
            $subTopics = CourseSubtopik::all();
            $subTopic = $quiz->sub_topic;

            $data = [
                'menu' => 'menu.v_menu_admin',
                'content' => 'quiz.edit',
                'title' => 'Edit Quiz: ' . $quiz->name,
                'quiz' => $quiz,
                'dimensions' => $dimensions,
                'subTopics' => $subTopics,
                'subTopic' => $subTopic,
            ];

            return view('layouts.v_template', $data);
        } catch (\Exception $e) {
            Log::error('Failed to load quiz edit page: ' . $e->getMessage(), [
                'quiz_id' => $quiz_id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors(['error' => 'Gagal menampilkan halaman edit: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */


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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $quiz_id)
    {
        try {
            // Validate form inputs with custom error messages
            $validated = $request->validate([
                'sub_topic_id' => 'required|integer|exists:mdl_course_subtopik,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'learning_style_id' => 'required|integer|exists:mdl_learning_styles,id',
                'time_open' => 'nullable|date',
                'time_close' => 'nullable|date|after:time_open',
                'time_limit' => 'nullable|integer|min:0|', // Minutes, max 180
                'max_attempts' => 'required|integer|min:1',
                'grade_to_pass' => 'required|numeric|min:0',
                'action' => 'required|in:save_return,save_display',
            ], [
                'sub_topic_id.exists' => 'The selected sub-topic is invalid.',
                'name.required' => 'Please provide a quiz name.',
                'name.max' => 'The quiz name cannot exceed 255 characters.',
                'learning_style_id.required' => 'Please select a learning dimension.',
                'learning_style_id.exists' => 'The selected dimension is invalid.',
                'time_close.after' => 'The close time must be after the open time.',
                'time_limit.min' => 'The time limit cannot be negative.',
                'max_attempts.required' => 'Please specify the number of attempts.',
                'max_attempts.min' => 'At least one attempt is required.',
                'grade_to_pass.required' => 'Please specify the grade to pass.',
                'grade_to_pass.min' => 'The grade to pass cannot be negative.',
                'action.in' => 'Invalid action selected.',
            ]);

            // Check for duplicate dimension in sub-topic (exclude current quiz)
            $existingQuiz = MDLQuiz::where('sub_topic_id', $validated['sub_topic_id'])
                ->where('learning_style_id', $validated['learning_style_id'])
                ->where('id', '!=', $quiz_id)
                ->exists();
            if ($existingQuiz) {
                Log::warning('Attempt to update quiz with duplicate dimension', [
                    'quiz_id' => $quiz_id,
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'learning_style_id' => $validated['learning_style_id'],
                ]);
                return redirect()->back()
                    ->with('error', 'A quiz for this dimension (processing, input, or persepsi) already exists for this sub-topic.')
                    ->withInput();
            }

            // Convert time_limit from minutes to seconds
            $timeLimitInSeconds = $validated['time_limit'] ? $validated['time_limit'] * 60 : null;

            // Update quiz
            $quiz = MDLQuiz::findOrFail($quiz_id);
            $quiz->update([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'time_open' => $validated['time_open'],
                'time_close' => $validated['time_close'],
                'time_limit' => $timeLimitInSeconds,
                'max_attempts' => $validated['max_attempts'],
                'grade_to_pass' => $validated['grade_to_pass'],
                'learning_style_id' => $validated['learning_style_id'],
            ]);

            Log::info('Quiz updated successfully', [
                'quiz_id' => $quiz->id,
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'learning_style_id' => $validated['learning_style_id'],
                'time_limit_seconds' => $timeLimitInSeconds,
                'action' => $validated['action'],
            ]);

            // Get redirect details
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            // Redirect based on action
            if ($validated['action'] === 'save_return') {
                return redirect()->route('sections.show', [$course_id, $section_id])
                    ->with('success', 'Quiz updated successfully.');
            } else {
                return redirect()->route('quizs.show', $quiz->id)
                    ->with('success', 'Quiz updated successfully.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for quiz update', [
                'quiz_id' => $quiz_id,
                'errors' => $e->errors(),
                'input' => $request->except('_token'),
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Please correct the errors below and try again.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error during quiz update', [
                'quiz_id' => $quiz_id,
                'message' => $e->getMessage(),
                'input' => $request->except('_token'),
            ]);
            return redirect()->back()
                ->with('error', 'An unexpected error occurred while updating the quiz. Please try again or contact support.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLQuiz  $mDLQuiz
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified quiz from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        try {
            // Cari kuis dengan relasi terkait untuk meminimalkan query
            $quiz = MDLQuiz::with(['sub_topic.section'])->findOrFail($id);

            // Simpan informasi untuk redirect sebelum penghapusan
            $courseId = $quiz->sub_topic->section->course_id ?? null;
            $sectionId = $quiz->sub_topic->section->id ?? null;
            $quizName = $quiz->name;

            DB::beginTransaction();



            // Hapus semua jawaban terkait dari mdl_quiz_answer
            MDLQuizAnswer::whereIn('attempt_id', $quiz->attempts()->pluck('id'))->delete();

            // Hapus semua percobaan terkait dari mdl_quiz_attempts
            $quiz->attempts()->delete();

            // Hapus semua pertanyaan terkait dari mdl_quiz_question
            $quiz->questions()->delete();

            // Hapus nilai (grades) terkait dari mdl_quiz_grades
            $quiz->grades()->delete();

            // Hapus kuis itu sendiri
            $quiz->delete();

            // Catat aktivitas penghapusan
            Log::info('Quiz deleted successfully', [
                'quiz_id' => $id,
                'quiz_name' => $quizName,
                'sub_topic_id' => $quiz->sub_topic_id,
                'user_id' => Auth::id() ?? 'unknown',
            ]);

            DB::commit();

            // Cek apakah permintaan mengharapkan respons JSON (untuk AJAX)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kuis berhasil dihapus!'
                ]);
            }

            // Cek apakah informasi redirect tersedia
            if (!$courseId || !$sectionId) {
                Log::warning('Course or section not found for quiz redirect', [
                    'quiz_id' => $id,
                    'course_id' => $courseId,
                    'section_id' => $sectionId
                ]);
                return redirect()->route('courses.index')
                    ->with('success', 'Kuis berhasil dihapus, tetapi tidak dapat mengarahkan ke halaman section.');
            }

            // Redirect ke halaman sections.show
            return redirect()->route('sections.show', [$courseId, $sectionId])
                ->with('success', 'Kuis berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete quiz: ' . $e->getMessage(), [
                'quiz_id' => $id,
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id() ?? 'unknown',
            ]);

            // Respons untuk AJAX
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus kuis: ' . $e->getMessage()
                ], 500);
            }

            // Respons untuk non-AJAX
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus kuis: ' . $e->getMessage()]);
        }
    }


    public function result($quizId, $attemptId)
    {
        //$quiz = MDLQuiz::findOrFail($quizId);
        $attempt = MDLQuizAttempts::with('answers.question')->findOrFail($attemptId);
        $quiz = MDLQuiz::with(['sub_topic.section.course'])->findOrFail($quizId);
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
