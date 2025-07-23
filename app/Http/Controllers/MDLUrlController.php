<?php

namespace App\Http\Controllers;

use App\Models\MDLUrl;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MDLUrlController extends Controller
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
        return view('url.create', compact('dimensions', 'subTopics','subTopic'));
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
                'name' => 'required|string',
                'url_link' => 'required|string',
                'description' => 'required',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',

            ]);

            // Ambil sub_topic untuk memastikan validitas dan mendapatkan course_id
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $url = DB::transaction(function () use ($validated) {
                $url = MDLUrl::create([
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'name' => $validated['name'],
                    'url_link' => $validated['url_link'],
                    'description' => $validated['description'],
                    'created_at' => now(),
                ]);

                $url->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_url_style', [
                    'url_id' => $url->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

                return $url;
            });

            // Redirect dengan pesan sukses
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Url berhasil disimpan!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to store url: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Tangani error dan kembalikan pesan gagal
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan url: ' . $e->getMessage()])->withInput();
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
            $url = MDLUrl::with('options')->findOrFail($id);
            $dimensions = MDLLearningStyles::with('options')->get();
            $subTopic = $url->sub_topic;

            return view('url.edit', compact('url', 'dimensions', 'subTopic'));
        } catch (\Exception $e) {
            Log::error('Failed to edit URL: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengedit URL: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'url_link' => 'required|url',
                'description' => 'required',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $url = MDLUrl::findOrFail($id);

            DB::transaction(function () use ($url, $validated) {
                $url->update([
                    'name' => $validated['name'],
                    'url_link' => $validated['url_link'],
                    'description' => $validated['description'],
                    'updated_at' => now(),
                ]);

                $url->options()->sync($validated['dimension_options']);
            });

            $subTopic = $url->sub_topic;
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'URL berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update URL: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui URL: ' . $e->getMessage()])->withInput();
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
            $url = MDLUrl::findOrFail($id);

            DB::beginTransaction();

            // Detach pivot entries in mdl_url_style
            $url->options()->detach();

            // Delete the url from the database
            $url->delete();

            Log::info('url deleted successfully', ['url_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'url berhasil dihapus!'
                ]);
            }

            // Redirect to course topics if sub_topic is null
            if (!$url->sub_topic) {
                Log::warning('Subtopic not found for url', ['url_id' => $id]);
                return redirect()->route('courses.topics', [$url->sub_topic->section->course_id ?? 1])
                    ->with('success', 'url berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            return redirect()->route('sections.show', [
                $url->sub_topic->section->course_id,
                $url->sub_topic->section->id
            ])->with('success', 'url berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete url: ' . $e->getMessage(), ['url_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus url: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus url. Silakan coba lagi.']);
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
