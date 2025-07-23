<?php

namespace App\Http\Controllers;

use App\Models\MDLUrl;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
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
        $learningStyles = DimensionOption::all();
        $subTopics = CourseSubtopik::all();


//            $data = [
//                'menu' => 'menu.v_menu_admin',
//                'content' => 'labels.create',
//                'subTopics' => $subTopics,
//                'learningStyles' =>  $learningStyles,
//                'count_user' => DB::table('users')->count(),
//            ];

//            return view('layouts.v_template', $data);
        return view('url.create', compact('learningStyles', 'subTopics','subTopic'));
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
                'learning_style_id' => 'required|exists:mdl_learning_styles,id',

            ]);

            // Ambil sub_topic untuk memastikan validitas dan mendapatkan course_id
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            MDLUrl::create([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'url_link' => $validated['url_link'],
                'description' => $validated['description'],
                'mdl_learning_style_id' => $validated['learning_style_id'],
                'created_at' => now(),
            ]);

            // Redirect dengan pesan sukses
            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Url berhasil disimpan!');
        } catch (\Exception $e) {
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

    }

    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
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
