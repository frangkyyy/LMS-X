<?php

namespace App\Http\Controllers;

use App\Models\MDLForum;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\MDLForumPost;
use App\Models\DimensionOption;
use Illuminate\Http\Request;

class MDLForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        {
            $forum = MDLForum::where('course_id', $course_id)->with(['posts.user'])->first();

            return view('forums.index');
        }

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
        return view('forum.create', compact('learningStyles', 'subTopics','subTopic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         dd($request->all());
        try {
            // Validasi input
            $validated = $request->validate([
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'name' => 'required|string|max:255',
                'learning_style_id' => 'required|exists:opsi_dimensi,id',
                'description' => 'required',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            MDLForum::create([
                'sub_topic_id' => $validated['sub_topic_id'],
                'name' => $validated['name'],
                'learning_style_id' => $validated['learning_style_id'],
                'description' => $validated['description'],
                'created_at' => now(),
            ]);


            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Forum berhasil disimpan!');
        } catch (\Exception $e) {
            // Tangani error dan kembalikan pesan gagal
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan forum: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function show(MDLForum $mDLForum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLForum $mDLForum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLForum $mDLForum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLForum $mDLForum)
    {
        //
    }
}
