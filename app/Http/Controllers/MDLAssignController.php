<?php

namespace App\Http\Controllers;

use App\Models\MDLAssign;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\MDLCourse;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MDLAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = MDLAssign::all();
        return view('assignments.index', compact('assignments'));
    }


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
        $dimensions = MDLLearningStyles::with('options')->get();
        $subTopics = CourseSubtopik::all();


//            $data = [
//                'menu' => 'menu.v_menu_admin',
//                'content' => 'labels.create',
//                'subTopics' => $subTopics,
//                'learningStyles' =>  $learningStyles,
//                'count_user' => DB::table('users')->count(),
//            ];

//            return view('layouts.v_template', $data);
        return view('assignments.create', compact('dimensions', 'subTopics','subTopic'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // Validasi input
            $validated = $request->validate([
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'name' => 'required|string|max:255',
                'description' => 'required',
                'due_date' => 'required|date',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $assign = DB::transaction(function () use ($validated) {
                $assign = MDLAssign::create([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date'],
                'created_at' => now(),
            ]);

                $assign->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_assign_style', [
                    'assign_id' => $assign->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

                return $assign;
            });


            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Assignment berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Failed to store assignment: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Tangani error dan kembalikan pesan gagal
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan assignment: ' . $e->getMessage()])->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            Log::info('Mencoba mengakses assignment show dengan ID: '.$id);

            $assignment = MDLAssign::with([
                'sub_topic.section.course',
                'submissions' => function($q) {
                    $q->with(['user', 'grade']);
                },
                'grades' => function($q) {
                    $q->where('user_id', auth()->id());

                }
            ])->findOrFail($id);

            $subTopic = $assignment->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;

            Log::info('Data assignment berhasil diambil', [
                'assignment_id' => $assignment->id,
                'user_id' => auth()->id(),
                'view' => 'assignments.showAssignment'
            ]);

            $viewData = [
                'menu' => 'menu.v_menu_admin',
                'content' => 'assignments.showAssignment',
                'title' => $assignment->name,
                'assignment' => $assignment,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
                'submission' => $assignment->submissions->first(),
                'grade' => $assignment->grades->first()
            ];

            Log::debug('Data yang dikirim ke view:', $viewData);

            return view('layouts.v_template', $viewData);

        } catch (\Exception $e) {
            Log::error('Gagal menampilkan halaman assignment', [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'assignment_id' => $id ?? null,
                'user_id' => auth()->id()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menampilkan halaman: '.$e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            Log::info('Attempting to edit assignment', ['assignment_id' => $id]);

            $assignment = MDLAssign::with(['options', 'sub_topic'])->findOrFail($id);
            $dimensions = MDLLearningStyles::with('options')->get();
            $subTopic = $assignment->sub_topic;

            Log::debug('Assignment data loaded', [
                'assignment' => $assignment->toArray(),
                'sub_topic' => $subTopic->toArray()
            ]);

            return view('assignments.edit', compact('assignment', 'dimensions', 'subTopic'));
        } catch (\Exception $e) {
            Log::error('Failed to edit assignment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'assignment_id' => $id
            ]);
            return redirect()->back()->withErrors(['error' => 'Failed to load assignment edit form']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Attempting to update assignment', ['assignment_id' => $id]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'due_date' => 'required|date',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $assignment = MDLAssign::findOrFail($id);

            DB::transaction(function () use ($assignment, $validated) {
                $assignment->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'due_date' => $validated['due_date'],
                    'updated_at' => now(),
                ]);

                $assignment->options()->sync($validated['dimension_options']);
            });

            $subTopic = $assignment->sub_topic;
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            Log::info('Assignment updated successfully', ['assignment_id' => $id]);

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Assignment berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update assignment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'assignment_id' => $id,
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update assignment: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $assignment = MDLAssign::findOrFail($id);

            DB::beginTransaction();

            // Hapus relasi dengan opsi dimensi (tabel mdl_assignment_style)
            $assignment->options()->detach();

            // Hapus semua percobaan (assign) dan jawaban terkait
            $submissions = $assignment->submissions()->get();
            foreach ($submissions as $submission) {
                $submission->feedback_comments()->delete(); // Hapus jawaban dari mdl_assignment_feedback_comments
                $submission->delete(); // Hapus percobaan dari mdl_assignment_submission
            }



            // Hapus nilai (grades) terkait dari mdl_assignment_grades
            $assignment->grades()->delete();

            // Hapus asignmen itu sendiri
            $assignment->delete();

            // Catat aktivitas penghapusan
            Log::info('assignment deleted successfully', [
                'assignment_id' => $id,
                'assignment_name' => $assignment->name,
                'sub_topic_id' => $assignment->sub_topic_id,
            ]);

            DB::commit();

            // Cek apakah permintaan mengharapkan respons JSON (untuk AJAX)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'tugas berhasil dihapus!'
                ]);
            }

            // Cek apakah subTopic tersedia untuk pengalihan
            if (!$assignment->sub_topic) {
                Log::warning('Subtopic not found for assignment', ['assignment_id' => $id]);
                return redirect()->route('courses.topics', [$assignment->sub_topic->section->course_id ?? 1])
                    ->with('success', 'tugas berhasil dihapus, tetapi subtopik tidak ditemukan.');
            }

            // Redirect ke halaman sections.show
            return redirect()->route('sections.show', [
                $assignment->sub_topic->section->course_id,
                $assignment->sub_topic->section->id
            ])->with('success', 'tugas berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete assignment: ' . $e->getMessage(), [
                'assignment_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus tugas: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus tugas: ' . $e->getMessage()]);
        }
    }

    public function submit(Request $request)
    {
        $request->validate([
            'assign_id' => 'required|exists:mdl_assign,id',
            'file_path' => 'required|array',
            'file_path.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,bmp|max:51200',
        ]);

        foreach ($request->file('file_path') as $file) {
            $path = $file->store('assignments', 'public');

            \App\Models\MDLAssignSubmission::create([
                'assign_id' => $request->assign_id,
                'user_id' => auth()->id(),
                'file_path' => 'storage/' . $path,
                'status' => 'submitted',
                'created_at' => now(),
            ]);
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

}
