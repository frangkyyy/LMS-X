<?php

namespace App\Http\Controllers;

use App\Models\MDLSection;
use App\Models\MDLCourse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CourseSubtopik;
use App\Models\Referensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class MDLSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        // Ambil data course berdasarkan ID
        // Cek apakah data course ditemukan
        $course = MDLCourse::where('id', $course_id)->first();
        if (!$course) {
            abort(404, "Course dengan ID $course_id tidak ditemukan.");
        }

        // Ambil semua section yang terkait dengan course ini dan visible
        $sections = MDLSection::where('course_id', $course_id)
            ->where('visible', 1)
            ->get();

        // Debug hasilnya
//        dd($course, $sections);

        // Kirim data ke view
        $data = [
            'menu' => 'menu.v_menu_admin', // Pastikan menu ini memang ada di template
            'content' => 'course.topikmatkul', // Perbaikan path view
            'title' => $course->full_name,
            'course' => $course,
            'sections' => $sections,
        ];

        return view('layouts.v_template', $data); // Perbaikan return
    }

    public function participants(MDLCourse $course)
    {
        $course->load(['users' => function($query) {
            $query->where('id_role', 3)
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.created_at'
                ]);
        }]);

        $data = [
            'course' => $course,
            'students' => $course->users, // Kirim data peserta langsung ke view
            'menu' => 'menu.v_menu_admin',
            'content' => 'content.view_participants',
            'title' => 'Daftar Peserta'
        ];

        return view('layouts.v_template', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'course.section.create',
            'title' => 'Create Section for ' . $course->full_name,
            'course' => $course,
            'count_user' => DB::table('users')->count(),
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $course_id)
    {
        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:mdl_course,id',
        ]);

        DB::beginTransaction();
        try {
            // Pastikan course_id dari URL dan request sama
            if ($request->course_id != $course_id) {
                throw new \Exception('Course ID mismatch');
            }

            // Hitung jumlah section yang sudah ada untuk course_id ini
            $existingSectionsCount = MDLSection::where('course_id', $course_id)->count();
            $newTopicNumber = $existingSectionsCount + 1;
            $newTitle = "Judul Topik {$newTopicNumber}";
            $newSortOrder = $newTopicNumber;

            // Simpan section baru langsung ke database
            $section = MDLSection::create([
                'course_id' => $course_id,
                'title' => $newTitle,
                'sort_order' => $newSortOrder,
                'visible' => 1, // Default visible = 1
            ]);

            Log::info('Section created', [
                'section_id' => $section->id,
                'course_id' => $course_id,
                'title' => $section->title,
                'sort_order' => $section->sort_order,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'section' => [
                    'id' => $section->id,
                    'title' => $section->title,
                    'sort_order' => $section->sort_order,
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create section: ' . $e->getMessage(), [
                'course_id' => $course_id,
                'request' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create section: ' . $e->getMessage(),
            ], 500);
        }
    }

        // ... metode lain tetap sama ...

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLSection  $mDLSection
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        // $section = MDLSection::with(['sub_topic', 'referensi'])
        //     ->where('id', $section_id)
        //     ->where('course_id', $course_id)
        //     ->firstOrFail();
            $section = MDLSection::with(['sub_topic.labels', 'sub_topic.pages','referensi'])
    ->where('id', $section_id)
    ->where('course_id', $course_id)
    ->firstOrFail();
        $sections = MDLSection::where('course_id', $course_id)
            ->where('visible', 1)
            ->orderBy('sort_order', 'asc') // Urutkan berdasarkan sort_order
            ->orderBy('id', 'asc') // Tiebreaker jika sort_order sama
            ->get();
        $indeks = $sections->search(function ($item) use ($section) {
                return $item->id == $section->id;
            }) + 1;

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'admin.course.sectionShow',
            'indeks' =>$indeks,
            'title' => $section->title,
            'course' => $course,
            'section' => $section,
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLSection  $mDLSection
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::with(['sub_topic', 'referensi'])
            ->where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $data = [
            'menu' => 'menu.v_menu_admin',
            'content' => 'admin.topic.edit',
            'title' => 'Edit Section: ' . $section->title,
            'course' => $course,
            'section' => $section,
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLSection  $mDLSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:Perkuliahan,Project,Studi Kasus,Ujian Sumatif',
            'title' => 'required|string|max:255',
            'deskripsi_topik' => 'required|string',
            'sub_cpmk' => 'required|string',
            'sub_topic.*.title' => 'required|string|max:255',
            'sub_topic.*.visible' => 'nullable|boolean',
            'sub_topic.*.sortorder' => 'required|integer|min:1',
            'referensi.*.content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {

            $section->update([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->deskripsi_topik,
                'sub_cpmk' => $request->sub_cpmk,
            ]);

            // Ambil ID sub topik dan referensi yang ada di input
            $inputSubTopicIds = [];
            $inputReferensiIds = [];


            if ($request->has('sub_topic')) {
                foreach ($request->sub_topic as $index => $sub_topic) {
                    $data = [
                        'section_id' => $section->id,
                        'title' => $sub_topic['title'],
                        'visible' => $sub_topic['visible'] ?? 1,
                        'sortorder' => $sub_topic['sortorder'] ?? ($index + 1),
                    ];

                    if (!empty($sub_topic['id'])) {
                        // Update sub topik yang ada
                        $existingSubTopic = CourseSubtopik::where('id', $sub_topic['id'])
                            ->where('section_id', $section->id)
                            ->first();
                        if ($existingSubTopic) {
                            $existingSubTopic->update($data);
                            $inputSubTopicIds[] = $sub_topic['id'];
                        }
                    } else {
                        // sub topik baru
                        $newSubTopic = CourseSubtopik::create($data);
                        $inputSubTopicIds[] = $newSubTopic->id;
                    }
                }
            }

            // Update atau buat referensi
            if ($request->has('referensi')) {
                foreach ($request->referensi as $referensi) {
                    $data = [
                        'section_id' => $section->id,
                        'content' => $referensi['content'],
                    ];

                    if (!empty($referensi['id'])) {
                        // Update referensi yang ada
                        $existingReferensi = Referensi::where('id', $referensi['id'])
                            ->where('section_id', $section->id)
                            ->first();
                        if ($existingReferensi) {
                            $existingReferensi->update($data);
                            $inputReferensiIds[] = $referensi['id'];
                        }
                    } else {
                        // referensi baru
                        $newReferensi = Referensi::create($data);
                        $inputReferensiIds[] = $newReferensi->id;
                    }
                }
            }

            // Hapus sub topik yang tidak ada di input
            CourseSubtopik::where('section_id', $section->id)
                ->whereNotIn('id', $inputSubTopicIds)
                ->delete();

            // Hapus referensi yang tidak ada di input
            Referensi::where('section_id', $section->id)
                ->whereNotIn('id', $inputReferensiIds)
                ->delete();

            DB::commit();

            return redirect()->route('sections.show', [$course_id, $section_id])
                ->with('success', 'Section updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating section: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui section: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLSection  $mDLSection
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $section_id)
    {
        $course = MDLCourse::where('id', $course_id)->firstOrFail();
        $section = MDLSection::where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $section->delete();

        return redirect()->route('sections.index', $course_id)
            ->with('success', 'Section deleted successfully.');
    }

     /**
     * Store a new sub topic for a section.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $course_id
     * @param int $section_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSubTopic(Request $request, $course_id, $section_id)
    {
        $section = MDLSection::where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'sortorder' => 'required|integer|min:1',
            'visible' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $subTopic = CourseSubtopik::create([
            'section_id' => $section->id,
            'title' => $request->title,
            'visible' => $request->visible ?? 1,
            'sortorder' => $request->sortorder,
        ]);

        return response()->json([
            'id' => $subTopic->id,
            'title' => $subTopic->title,
            'sortorder' => $subTopic->sortorder,
            'visible' => $subTopic->visible,
        ], 201);
    }
      /**
     * Delete a sub topic.
     *
     * @param int $course_id
     * @param int $section_id
     * @param int $subtopic_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySubTopic($course_id, $section_id, $subtopic_id)
    {
        $section = MDLSection::where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $subTopic = CourseSubtopik::where('id', $subtopic_id)
            ->where('section_id', $section->id)
            ->firstOrFail();

        $subTopic->delete();

        return response()->json(['message' => 'Sub topic deleted successfully.']);
    }

     /**
     * Store a new referensi for a section.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $course_id
     * @param int $section_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReferensi(Request $request, $course_id, $section_id)
    {
        $section = MDLSection::where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $referensi = Referensi::create([
            'section_id' => $section->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'id' => $referensi->id,
            'content' => $referensi->content,
        ], 201);


    }
       /**
     * Delete a referensi.
     *
     * @param int $course_id
     * @param int $section_id
     * @param int $referensi_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyReferensi($course_id, $section_id, $referensi_id)
    {
        $section = MDLSection::where('id', $section_id)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $referensi = Referensi::where('id', $referensi_id)
            ->where('section_id', $section->id)
            ->firstOrFail();

        $referensi->delete();

        return response()->json(['message' => 'Referensi deleted successfully.']);
    }




}
