<?php

namespace App\Http\Controllers;

use App\Models\MDLSection;
use App\Models\MDLCourse;
use App\Models\CourseSubtopik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CourseSubtopikController extends Controller
{
    public function index($course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();
        $subtopics = CourseSubtopik::where('section_id', $section_id)->orderBy('sortorder')->get();

        return view('sections.index', compact('course', 'section', 'subtopics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();


        $data = [
            'menu' => 'menu.v_menu_admin', // Pastikan menu ini memang ada di template
            'content' => 'admin.subtopic.create', // Perbaikan path view
            'course' => $course,
            'section' => $section,
        ];

        return view('layouts.v_template', $data); // Perbaikan return

        //\Log::info("Reached create: course_id=$course_id, section_id=$section_id");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $course_id, $section_id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:mdl_section,id',
            'title' => 'required|string|max:255',
            'visible' => 'nullable|boolean',
            'sortorder' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Pastikan section_id dari URL dan request sama
            if ($request->section_id != $section_id) {
                throw new \Exception('Section ID mismatch');
            }

            // Pastikan section berada di bawah course yang benar
            $section = MDLSection::where('id', $section_id)
                ->where('course_id', $course_id)
                ->firstOrFail();

            // Hitung jumlah subtopik yang sudah ada untuk section ini
            $existingSubTopicsCount = CourseSubtopik::where('section_id', $section_id)->count();
            $newSortOrder = $request->sortorder;

            // Simpan subtopik baru langsung ke database
            $subTopic = CourseSubtopik::create([
                'section_id' => $section->id,
                'title' => $request->title,
                'visible' => $request->visible ?? 1,
                'sortorder' => $newSortOrder,
            ]);

            Log::info('Subtopic created', [
                'subtopic_id' => $subTopic->id,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'title' => $subTopic->title,
                'sortorder' => $subTopic->sortorder,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'subtopic' => [
                        'id' => $subTopic->id,
                        'title' => $subTopic->title,
                        'visible' => $subTopic->visible,
                        'sortorder' => $subTopic->sortorder,
                    ],
                ], 201);
            }



            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Subtopic created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create subtopic: ' . $e->getMessage(), [
                'section_id' => $section_id,
                'course_id' => $course_id,
                'request' => $request->all(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create subtopic: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Failed to create subtopic: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified subtopic.
     *
     * @param int $course_id
     * @param int $section_id
     * @param int $subtopic_id
     * @return \Illuminate\View\View
     */
    public function edit($course_id, $section_id, $subtopic_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();
        $subtopic = CourseSubtopik::where('id', $subtopic_id)->where('section_id', $section_id)->firstOrFail();



        $data = [
            'menu' => 'menu.v_menu_admin', // Pastikan menu ini memang ada di template
            'content' => 'admin.subtopic.edit', // Perbaikan path view
            'course' => $course,
            'section' => $section,
            'subtopic' => $subtopic,
        ];

        return view('layouts.v_template', $data); // Perbaikan return


    }

    /**
     * Update the specified subtopic in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $course_id
     * @param int $section_id
     * @param int $subtopic_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $course_id, $section_id, $subtopic_id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:mdl_section,id',
            'title' => 'required|string|max:255',
            'visible' => 'nullable|boolean',
            'sortorder' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Pastikan section_id dari URL dan request sama
            if ($request->section_id != $section_id) {
                throw new \Exception('Section ID mismatch');
            }

            // Pastikan section berada di bawah course yang benar
            $section = MDLSection::where('id', $section_id)
                ->where('course_id', $course_id)
                ->firstOrFail();

            // Cari subtopik
            $subTopic = CourseSubtopik::where('id', $subtopic_id)
                ->where('section_id', $section_id)
                ->firstOrFail();

            // Update subtopik
            $subTopic->update([
                'section_id' => $section->id,
                'title' => $request->title,
                'visible' => $request->visible ?? 1,
                'sortorder' => $request->sortorder,
            ]);

            Log::info('Subtopic updated', [
                'subtopic_id' => $subTopic->id,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'title' => $subTopic->title,
                'sortorder' => $subTopic->sortorder,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'subtopic' => [
                        'id' => $subTopic->id,
                        'title' => $subTopic->title,
                        'visible' => $subTopic->visible,
                        'sortorder' => $subTopic->sortorder,
                    ],
                ], 200);
            }

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Subtopic updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update subtopic: ' . $e->getMessage(), [
                'subtopic_id' => $subtopic_id,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'request' => $request->all(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update subtopic: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Failed to update subtopic: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
