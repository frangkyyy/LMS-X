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

    public function getPostsByForum($forumId)
    {
        $posts = MDLForumPost::with('user')
            ->where('forum_id', $forumId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($posts);
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'post' => $post->load('user')
            ]);
        }

        return redirect()->route('forums.show', $forum->id)
            ->with('success', 'Komentar berhasil dikirim!');
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
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengedit komentar ini.'], 403);
        }

        $post->content = $request->input('content');
        $post->save();

        return response()->json(['success' => true]);
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
            $post = MDLForumPost::findOrFail($id);

            // Validasi kepemilikan komentar
            if ($post->user_id != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus komentar ini!'
                ], 403);
            }

            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus komentar: ' . $e->getMessage()
            ], 500);
        }
    }
}
