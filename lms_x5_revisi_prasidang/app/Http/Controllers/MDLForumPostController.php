<?php

namespace App\Http\Controllers;

use App\Models\MDLForumPost;
use App\Models\MDLForum;
use App\Models\MDLCourse;
use App\Models\MDLActive;
use App\Models\MDLFiles;
use Illuminate\Http\Request;

class MDLForumPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'forum_id' => 'required|exists:mdl_forum,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $forum = MDLForum::findOrFail($request->forum_id);

        $post = MDLForumPost::create([
            'forum_id' => $request->forum_id,
            'user_id' => $request->user_id,
            'content' => $request->input('content'),
        ]);

        // Get user's learning style combination
        $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
        $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);

        return redirect()->route($styleSlug, [
            'course_id' => $forum->course_id,
            'topik' => $forum->section_id,
            'section_id' => $forum->section_id
        ])->with('success', 'Komentar berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLForumPost  $mDLForumPost
     * @return \Illuminate\Http\Response
     */
    public function show(MDLForumPost $mDLForumPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLForumPost  $mDLForumPost
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = MDLForumPost::findOrFail($id);
        $forum = MDLForum::findOrFail($post->forum_id);
        $course = MDLCourse::findOrFail($forum->course_id);

        // Get user's learning style combination
        $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
        $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'forum.edit',
            'title' => 'Edit Komentar',
            'course' => $course,
            'forum' => $forum,
            'post' => $post,
            'styleSlug' => $styleSlug, // Pass styleSlug to view for form action
            'course_id' => $course->id,
            'section_id' => $forum->section_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLForumPost  $mDLForumPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = MDLForumPost::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }

        $post->content = $request->input('content');
        $post->save();

        // Get user's learning style combination
        $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
        $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);

        return redirect()->route($styleSlug, [
            'course_id' => $post->forum->course_id,
            'topik' => $post->forum->section_id,
            'section_id' => $post->forum->section_id
        ])->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = MDLForumPost::findOrFail($id);

        if ($post->user_id != auth()->id()) {
            return back()->with('error', 'Akses ditolak!');
        }

        $post->delete();

        // Get user's learning style combination
        $styleCombination = \App\Helpers\LearningStyleHelper::getUserLearningStyleCombination();
        $styleSlug = \App\Helpers\LearningStyleHelper::getStyleSlug($styleCombination);

        return redirect()->route($styleSlug, [
            'course_id' => $post->forum->course_id,
            'topik' => $post->forum->section_id,
            'section_id' => $post->forum->section_id
        ])->with('success', 'Komentar berhasil dihapus!');
    }
}
