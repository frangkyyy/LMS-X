<?php

namespace App\Http\Controllers;

use App\Models\MDLPage;
use App\Models\CourseSubtopik;
use App\Models\MDLCourse;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
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

        // Ambil sub-topik spesifik berdasarkan sub_topic_id
        $subTopic = CourseSubtopik::findOrFail($subTopicId);
        $learningStyles = DimensionOption::all();
        $subTopics = CourseSubtopik::all();

        return view('pages.create', compact('learningStyles', 'subTopics','subTopic'));
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
        $validated = $request->validate([

            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
            'learning_style_id' => 'required|exists:opsi_dimensi,id',

        ]);

        $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);


        MDLPage::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'content' => $validated['content'],
            'learning_style_id' => $validated['learning_style_id'],
            'sub_topic_id' => $validated['sub_topic_id'],

        ]);
        $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
        $section = $subTopic->section;
        $course_id = $section->course_id;
        $section_id = $section->id;

        return redirect()->route('sections.show', [$course_id, $section_id])
        ->with('success', 'Label berhasil disimpan!');
    } catch (\Exception $e) {
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
        $page = MDLPage::findOrFail($id);
        $course = MDLCourse::find($page->course_id);

        // Ambil nilai enum dari database
        $learningStyles = $this->getEnumValues('mdl_page', 'learning_style');
        $topik = $this->getEnumValues('mdl_page', 'topik');
        $type = $this->getEnumValues('mdl_page', 'type');

        return view('pages.edit', [
            'page' => $page,
            'course' => $course,
            'learningStyles' => $learningStyles,
            'topik' => $topik,
            'type' => $type
        ]);
    }
public function update(Request $request, $id)
{
    $page = MDLPage::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'content' => 'required|string',
        'learning_style' => 'required|string|in:' . implode(',', $this->getEnumValues('mdl_page', 'learning_style')),
        'topik' => 'required|string|in:' . implode(',', $this->getEnumValues('mdl_page', 'topik')),
        'type' => 'required|string|in:' . implode(',', $this->getEnumValues('mdl_page', 'type'))
    ]);

    $page->update($validated);

    return redirect()->route('course.section', [
        'course_id' => $page->course_id,
        'topik' => $request->topik,
        'section_id' => $request->section_id
    ])->with('success', 'Page berhasil diperbarui');
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
