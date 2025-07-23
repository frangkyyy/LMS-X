<?php

namespace App\Http\Controllers;

use App\Models\MDLPage;
use App\Models\CourseSubtopik;
use App\Models\MDLCourse;
use App\Models\DimensionOption;
use App\Models\MDLLearningStyles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MDLPageController extends Controller
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


        $subTopic = CourseSubtopik::findOrFail($subTopicId);

        $subTopics = CourseSubtopik::all();
        // $dimesions= MDLLearningStyles:: all();
        // $options = DimensionOption::all();
        $dimensions = MDLLearningStyles::with('options')->get();

        return view('pages.create', compact( 'subTopics','subTopic', 'dimensions'));
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
            // Validate the request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'content' => 'nullable|string',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);
            // Get subtopic and related section data
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            $page = DB::transaction(function () use ($validated) {
                // Create the new page
                $page = MDLPage::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'content' => $validated['content'],
                    'sub_topic_id' => $validated['sub_topic_id'],
                ]);

                $page->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_page_style', [
                    'page_id' => $page->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

                return $page;
            });

            // Redirect to sections.show
            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Page berhasil disimpan!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to store page: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Return with error
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan Page: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        try {

            $page = MDLPage::with(['sub_topic.section.course', 'options'])->findOrFail($id);
            $subTopic = $page->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;

            // Siapkan data untuk v_template
            $data = [
                'menu' => 'menu.v_menu_admin', // Sesuaikan dengan menu yang tepat
                'content' => 'pages.showpage', // View konten utama
                'title' => $page->name, // Judul halaman
                'page' => $page,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
                'options' => $page->options,
            ];

            return view('layouts.v_template', $data);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menampilkan halaman: ' . $e->getMessage()]);
        }
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
            $page = MDLPage::with(['sub_topic.section.course', 'options'])->findOrFail($id);
            $subTopic = $page->sub_topic;
            $subTopics = CourseSubtopik::all();
            $dimensions = MDLLearningStyles::with('options')->get();

            return view('pages.edit', compact('page', 'subTopic', 'subTopics', 'dimensions'));
        } catch (\Exception $e) {
            Log::error('Failed to load edit page: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal memuat halaman edit: ' . $e->getMessage()]);
        }
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
        try {
            $page = MDLPage::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'content' => 'nullable|string',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            DB::transaction(function () use ($page, $validated) {
                $page->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'content' => $validated['content'],
                    'sub_topic_id' => $validated['sub_topic_id'],
                ]);

                $page->options()->sync($validated['dimension_options']);
                Log::info('Updated dimension options for mdl_page_style', [
                    'page_id' => $page->id,
                    'dimension_options' => $validated['dimension_options']
                ]);
            });

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Page berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update page: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui Page: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $page = MDLPage::findOrFail($id);

            DB::beginTransaction();

            // Detach pivot entries in mdl_page_style
            $page->options()->detach();

            // Delete the page from the database
            $page->delete();

            Log::info('Page deleted successfully', ['page_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page berhasil dihapus!'
                ]);
            }

            // Redirect to course topics if sub_topic is null
            if (!$page->sub_topic) {
                Log::warning('Subtopic not found for page', ['page_id' => $id]);
                return redirect()->route('courses.topics', [$page->sub_topic->section->course_id ?? 1])
                    ->with('success', 'Page berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            // Verify route existence
            if (!\Route::has('sections.show')) {
                Log::error('Route sections.show does not exist', [
                    'page_id' => $id,
                    'course_id' => $page->sub_topic->section->course_id,
                    'section_id' => $page->sub_topic->section->id,
                ]);
                throw new \Exception('Route sections.show is not defined.');
            }

            return redirect()->route('sections.show', [
                $page->sub_topic->section->course_id,
                $page->sub_topic->section->id
            ])->with('success', 'Page berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete page: ' . $e->getMessage(), [
                'page_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus page: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus page. Silakan coba lagi.']);
        }
    }

    /**
     * Get enum values from a table column.
     *
     * @param  string  $table
     * @param  string  $column
     * @return array
     */
    private function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        if (!isset($matches[1])) {
            return [];
        }

        return str_getcsv($matches[1], ',', "'");
    }
}
