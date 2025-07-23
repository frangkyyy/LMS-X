<?php

namespace App\Http\Controllers;

use App\Models\MDLLesson;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MDLLessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {

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
        return view('lessons.create', compact('dimensions', 'subTopics','subTopic'));
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
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $lesson = DB::transaction(function () use ($validated) {
                $lesson = MDLLesson::create([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'created_at' => now(),
            ]);

                $lesson->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_lesson_style', [
                    'lesson_id' => $lesson->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

                return $lesson;
            });

            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Lesson berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Failed to store lesson: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Tangani error dan kembalikan pesan gagal
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan lesson: ' . $e->getMessage()])->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $lesson = MDLLesson::with('options')->findOrFail($id);
            $dimensions = MDLLearningStyles::with('options')->get();
            $subTopic = $lesson->sub_topic;

            return view('lessons.edit', compact('lesson', 'dimensions', 'subTopic'));
        } catch (\Exception $e) {
            Log::error('Failed to edit lesson: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengedit lesson: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $lesson = MDLLesson::findOrFail($id);

            DB::transaction(function () use ($lesson, $validated) {
                $lesson->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'updated_at' => now(),
                ]);

                $lesson->options()->sync($validated['dimension_options']);
            });

            $subTopic = $lesson->sub_topic;
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Lesson berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update lesson: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui lesson: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $lesson = MDLLesson::findOrFail($id);

            DB::beginTransaction();

            // Detach pivot entries in mdl_lesson_style
            $lesson->options()->detach();

            // Delete the lesson from the database
            $lesson->delete();

            Log::info('Lesson deleted successfully', ['lesson_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lesson berhasil dihapus!'
                ]);
            }

            // Redirect to course topics if sub_topic is null
            if (!$lesson->sub_topic) {
                Log::warning('Subtopic not found for lesson', ['lesson_id' => $id]);
                return redirect()->route('courses.topics', [$lesson->sub_topic->section->course_id ?? 1])
                    ->with('success', 'Lesson berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            // Verify route existence
            if (!\Route::has('sections.show')) {
                Log::error('Route sections.show does not exist', [
                    'lesson_id' => $id,
                    'course_id' => $lesson->sub_topic->section->course_id,
                    'section_id' => $lesson->sub_topic->section->id,
                ]);
                throw new \Exception('Route sections.show is not defined.');
            }

            return redirect()->route('sections.show', [
                $lesson->sub_topic->section->course_id,
                $lesson->sub_topic->section->id
            ])->with('success', 'Lesson berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete lesson: ' . $e->getMessage(), [
                'lesson_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus lesson: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus lesson. Silakan coba lagi.']);
        }
    }

    private function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        if (!isset($matches[1])) {
            return [];
        }

        $enum = str_getcsv($matches[1], ',', "'");

        return $enum;
    }
}
