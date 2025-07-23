<?php

namespace App\Http\Controllers;

use App\Models\MDLSection;
use App\Models\MDLCourse;
use App\Models\CourseSubtopik;
use Illuminate\Http\Request;
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

        return view('sections.index', compact('course', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'visible' => 'nullable|boolean',
            'sortorder' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        CourseSubtopik::create([
            'section_id' => $section->id,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'visible' => $request->visible ?? 1,
            'sortorder' => $request->sortorder,
        ]);

        return redirect()->route('subtopics.index', [$course_id, $section_id])
            ->with('success', 'Sub topik created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($course_id, $section_id, $subtopic_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();
        $subtopic = CourseSubtopik::where('id', $subtopic_id)->where('section_id', $section_id)->firstOrFail();

        return view('sections.index', compact('course', 'section', 'subtopic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($course_id, $section_id, $subtopic_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();
        $subtopic = CourseSubtopik::where('id', $subtopic_id)->where('section_id', $section_id)->firstOrFail();

        return view('sections.index', compact('course', 'section', 'subtopic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $course_id, $section_id, $subtopic_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();
        $subtopic = CourseSubtopik::where('id', $subtopic_id)->where('section_id', $section_id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'visible' => 'nullable|boolean',
            'sortorder' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $subtopic->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'visible' => $request->visible ?? 1,
            'sortorder' => $request->sortorder,
        ]);

        return redirect()->route('sections.index', [$course_id, $section_id])
            ->with('success', 'Sub topik updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($course_id, $section_id, $subtopic_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)->where('course_id', $course_id)->firstOrFail();
        $subtopic = CourseSubtopik::where('id', $subtopic_id)->where('section_id', $section_id)->firstOrFail();

        $subtopic->delete();

        return redirect()->route('sections.index', [$course_id, $section_id])
            ->with('success', 'Sub topik deleted successfully.');
    }
}
 