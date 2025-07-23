<?php

namespace App\Http\Controllers;

use App\Models\MDLLabel;
use App\Models\MDLLearningStyles;
use App\Models\CourseSubtopik;
use App\Models\MDLCourse;
use Illuminate\Support\Facades\Log;
use App\Models\DimensionOption;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MDLLabelController extends Controller
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
    // public function create()
    // {
    //     $learningStyles = DimensionOption::all();
    //     $subTopics = CourseSubtopik::all();

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
            return view('labels.create', compact('dimensions', 'subTopics','subTopic'));
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
                'konten' => 'required|string',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
            ]);

            // Ambil sub_topic untuk memastikan validitas dan mendapatkan course_id
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $label = DB::transaction(function () use ($validated) {
            // Simpan data ke MDLLabel
            $label = MDLLabel::create([
                'konten' => $validated['konten'],
                'sub_topic_id' => $validated['sub_topic_id'],
            ]);

            $label->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_label_style', [
                    'label_id' => $label->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

            return $label;
            });

            // Redirect dengan pesan sukses
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
            ->with('success', 'Label berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Failed to store label: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Tangani error dan kembalikan pesan gagal
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan label: ' . $e->getMessage()])->withInput();
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
        $label = MDLLabel::with(['options', 'sub_topic.section'])->findOrFail($id); // Changed 'subTopic' to 'sub_topic'
        $dimensions = MDLLearningStyles::with('options')->get();

        // Get selected dimension IDs
        $selectedDimensions = $label->options->pluck('mdl_learning_styles_id')->unique()->toArray();

        // Get selected option IDs
        $selectedOptions = $label->options->pluck('id')->toArray();

        // Get all options from selected dimensions
        $dimensionOptions = DimensionOption::whereIn('mdl_learning_styles_id', $selectedDimensions)->get();

        return view('labels.edit', compact(
            'label',
            'dimensions',
            'selectedDimensions',
            'dimensionOptions',
            'selectedOptions'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            // Log incoming request data
            Log::info('Label update request received', [
                'label_id' => $id,
                'request_data' => $request->all(),
                'ip_address' => $request->ip(),
                'user_id' => auth()->id(),
            ]);

            // Validasi input
            $validated = $request->validate([
                'konten' => 'required|string',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
            ]);

            Log::info('Validation passed', [
                'label_id' => $id,
                'validated_data' => $validated,
            ]);

            $label = MDLLabel::findOrFail($id);

            Log::info('Label found', [
                'label_id' => $id,
                'label_data' => $label->toArray(),
            ]);

            DB::transaction(function () use ($validated, $label) {
                // Update data label
                $label->update([
                    'konten' => $validated['konten'],
                ]);

                Log::info('Label konten updated', [
                    'label_id' => $label->id,
                    'konten' => $validated['konten'],
                ]);

                // Sync dimension options
                $label->options()->sync($validated['dimension_options']);

                Log::info('Dimension options synced', [
                    'label_id' => $label->id,
                    'dimension_options' => $validated['dimension_options'],
                ]);
            });

            // Load sub_topic relationship
            $subTopic = $label->sub_topic; // Use snake_case as per model definition
            if (!$subTopic) {
                Log::error('Subtopic not found for label', [
                    'label_id' => $id,
                    'sub_topic_id' => $label->sub_topic_id,
                ]);
                throw new \Exception('Subtopic not found for this label.');
            }

            Log::info('Subtopic loaded', [
                'label_id' => $id,
                'sub_topic_id' => $subTopic->id,
                'sub_topic_title' => $subTopic->title,
            ]);

            $section = $subTopic->section;
            if (!$section) {
                Log::error('Section not found for subtopic', [
                    'label_id' => $id,
                    'sub_topic_id' => $subTopic->id,
                ]);
                throw new \Exception('Section not found for this subtopic.');
            }

            Log::info('Section loaded', [
                'label_id' => $id,
                'section_id' => $section->id,
                'course_id' => $section->course_id,
            ]);

            $course_id = $section->course_id;
            $section_id = $section->id;

            // Verify route existence
            if (!\Route::has('sections.show')) {
                Log::error('Route sections.show does not exist', [
                    'label_id' => $id,
                    'course_id' => $course_id,
                    'section_id' => $section_id,
                ]);
                throw new \Exception('Route sections.show is not defined.');
            }

            // Generate and log the redirect URL
            $redirectUrl = route('sections.show', [$course_id, $section_id]);
            Log::info('Preparing to redirect to sections.show', [
                'label_id' => $id,
                'course_id' => $course_id,
                'section_id' => $section_id,
                'redirect_url' => $redirectUrl,
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Label berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update label: ' . $e->getMessage(), [
                'label_id' => $id,
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui label: ' . $e->getMessage()])
                ->withInput();
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
            $label = MDLLabel::findOrFail($id);

            DB::beginTransaction();

            // Detach pivot entries in mdl_label_style
            $label->options()->detach();

            // Delete the label from the database
            $label->delete();

            Log::info('Label deleted successfully', ['label_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Label berhasil dihapus!'
                ]);
            }

            // Redirect to course topics if sub_topic is null
            if (!$label->sub_topic) {
                Log::warning('Subtopic not found for label', ['label_id' => $id]);
                return redirect()->route('courses.topics', [$label->sub_topic->section->course_id ?? 1])
                    ->with('success', 'Label berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            return redirect()->route('sections.show', [
                $label->sub_topic->section->course_id,
                $label->sub_topic->section->id
            ])->with('success', 'Label berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete label: ' . $e->getMessage(), ['label_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus label: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus label. Silakan coba lagi.']);
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
