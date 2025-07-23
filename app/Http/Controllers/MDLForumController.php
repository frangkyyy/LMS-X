<?php

namespace App\Http\Controllers;

use App\Models\MDLForum;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\MDLForumPost;
use App\Models\DimensionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $dimensions = MDLLearningStyles::with('options')->get();
        $subTopics = CourseSubtopik::all();


        return view('forum.create', compact('dimensions', 'subTopics','subTopic'));
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
                'description' => 'required',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $forum = DB::transaction(function () use ($validated) {
                $forum = MDLForum::create([
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'created_at' => now(),
                ]);

                $forum->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_forum_style', [
                    'forum_id' => $forum->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

                return $forum;
            });


            $subTopic = CourseSubtopik::findOrFail($request->sub_topic_id);
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Forum berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Failed to store forum: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
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
    public function show($id)
    {
        try {

            $forum = MDLForum::with(['sub_topic.section.course', 'options', 'posts.user'])->findOrFail($id);
            $subTopic = $forum->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;

            // Siapkan data untuk v_template
            $data = [
                'menu' => 'menu.v_menu_admin', // Sesuaikan dengan menu yang tepat
                'content' => 'forum.showforum', // View konten utama
                'title' => $forum->name, // Judul halaman
                'forum' => $forum,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
                'options' => $forum->options,
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
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $forum = MDLForum::with('options')->findOrFail($id);
            $dimensions = MDLLearningStyles::with('options')->get();
            $subTopic = $forum->sub_topic;

            return view('forum.editlom', compact('forum', 'dimensions', 'subTopic'));
        } catch (\Exception $e) {
            Log::error('Failed to edit forum: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengedit forum: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'name' => 'required|string|max:255',
                'description' => 'required',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $forum = MDLForum::findOrFail($id);

            DB::transaction(function () use ($forum, $validated) {
                $forum->update([
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'updated_at' => now(),
                ]);

                $forum->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_forum_style', [
                    'forum_id' => $forum->id,
                    'dimension_options' => $validated['dimension_options']
                ]);
            });

            $subTopic = $forum->sub_topic;
            $section = $subTopic->section;
            $course_id = $section->course_id;
            $section_id = $section->id;

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Forum berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update forum: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui forum: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLForum  $mDLForum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $forum = MDLForum::findOrFail($id);

            DB::beginTransaction();

            // Hapus entri pivot di mdl_forum_style
            $forum->options()->detach();

            // Hapus semua post terkait dari mdl_forum_posts
            MDLForumPost::where('forum_id', $id)->delete();

            // Hapus forum dari database
            $forum->delete();

            Log::info('Forum deleted successfully', ['forum_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Forum berhasil dihapus!'
                ]);
            }

            // Redirect ke halaman kursus jika subTopic null
            if (!$forum->sub_topic) {
                Log::warning('Subtopic not found for forum', ['forum_id' => $id]);
                return redirect()->route('courses.topics', [$forum->sub_topic->section->course_id ?? 1])
                    ->with('success', 'Forum berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            return redirect()->route('sections.show', [
                $forum->sub_topic->section->course_id,
                $forum->sub_topic->section->id
            ])->with('success', 'Forum berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete forum: ' . $e->getMessage(), ['forum_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus forum: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus forum. Silakan coba lagi.']);
        }
    }
}
