<?php

namespace App\Http\Controllers;

use App\Models\MDLAssign;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\MDLCourse;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
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
        return view('assignments.create', compact('learningStyles', 'subTopics','subTopic'));
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
                'learning_style_id' => 'required|exists:mdl_learning_styles,id',
                'description' => 'required',
                'due_date' => 'required|date',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            MDLAssign::create([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'learning_style_id' => $validated['learning_style_id'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date'],
                'created_at' => now(),
            ]);


            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Assignment berhasil disimpan!');
        } catch (\Exception $e) {
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
    public function show($id){
        try {
            $assignment = MDLAssign::with([
                'sub_topic.section.course',
                'learning_style',
                'submissions' => function($q) {
                    $q->where('user_id', auth()->id());
                },
                'grades' => function($q) {
                    $q->where('user_id', auth()->id());
                }
            ])->findOrFail($id);

            $subTopic = $assignment->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;

            return view('layouts.v_template', [
                'menu' => 'menu.v_menu_admin',
                'content' => 'assignments.showAssignment',
                'title' => $assignment->name,
                'assignment' => $assignment,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
                'submission' => $assignment->submissions->first(),
                'grade' => $assignment->grades->first()
            ]);

        } catch (\Exception $e) {
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
    public function edit(MDLAssign $mDLAssign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLAssign $mDLAssign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLAssign  $mDLAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLAssign $mDLAssign)
    {
        //
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
