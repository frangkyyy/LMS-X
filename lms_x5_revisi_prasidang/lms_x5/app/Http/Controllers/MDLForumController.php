<?php

namespace App\Http\Controllers;

use App\Models\MDLForum;
use App\Models\MDLForumPost;
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
    public function create()
    {
        $learningStyles = MDLForum::select('learning_style')
            ->distinct()
            ->whereNotNull('learning_style')
            ->pluck('learning_style');

        $topik = MDLForum::select('topik')
            ->distinct()
            ->whereNotNull('topik')
            ->pluck('topik');

        return view('forums.create', compact('learningStyles', 'topik'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'learning_style' => 'required|string|max:50',
            'topik' => 'required|string|max:100',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:mdl_course,id',
            'section_id' => 'required|exists:mdl_section,id',
            // 'forum_type' => 'required|string|in:simple_discussion,standard_forum',
        ]);

        MDLForum::create([
            'name' => $request->name,
            'learning_style' => $request->learning_style,
            'topik' => $request->topik,
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'description' => $request->description,
            // 'forum_type' => $request->forum_type,
        ]);

        return redirect()->back()->with('success', 'Assignment berhasil dibuat!');
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
