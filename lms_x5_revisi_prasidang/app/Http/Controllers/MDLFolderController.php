<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\MDLFolder;
use Illuminate\Http\Request;

use App\Models\CourseSubtopik;
use App\Models\DimensionOption;
use App\Models\MDLFileSave;


use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Storage;



class MDLFolderController extends Controller
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



//            $data = [
//                'menu' => 'menu.v_menu_admin',
//                'content' => 'labels.create',
//                'subTopics' => $subTopics,
//                'learningStyles' =>  $learningStyles,
//                'count_user' => DB::table('users')->count(),
//            ];

//            return view('layouts.v_template', $data);
        return view('folder.create', compact('learningStyles', 'subTopics','subTopic'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        // Validate the request
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'learning_style_id' => 'required|exists:opsi_dimensi,id',
            'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:' . config('app.max_file_size', 5120),
        ]);

        // Return errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get validated data
        $validated = $validator->validated();

        // Log validated data for debugging
        \Log::debug('Validated data:', $validated);

        try {
            // Start a database transaction
            $folder = DB::transaction(function () use ($request, $validated) {
                // Verify sub-topic exists

                // Create folder
                $folder = MDLFolder::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'learning_style_id' => $validated['learning_style_id'],
                    'sub_topic_id' => $validated['sub_topic_id'],
                    // Consider removing if unused
                ]);

                // Process uploaded files
                if ($request->hasFile('files')) {
                    foreach ($request->file('files') as $file) {
                        // Sanitize and generate unique file name
                        $originalName = $file->getClientOriginalName();
                        $sanitizedName = preg_replace('/[^A-Za-z0-9\-\\.]/', '', str_replace(' ', '', $originalName));
                        $fileName = time() . '_' . $sanitizedName;
                        $filePath = $file->storeAs('uploads/folders', $fileName, 'public');

                        // Save file metadata
                        MDLFileSave::create([
                            'folder_id' => $folder->id,
                            'name' => $originalName,
                            'description' => null,
                            'file_path' => $filePath,
                        ]);
                    }
                }

                return $folder;

            });

            // Redirect to a specific route with success message
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success',  ' file berhasil disimpan!');        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to create folder or files: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to create folder or files. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try {
            $folder = MDLFolder::with([
                'sub_topic.section.course',
                'learning_style',
                'files_save' // Memuat file-file terkait folder
            ])->findOrFail($id);
            $subTopic = $folder->sub_topic;
            $section = $subTopic->section;
            $course = $section->course;

            // Siapkan data untuk v_template
            $data = [
                'menu' => 'menu.v_menu_admin', // Sesuaikan dengan menu yang tepat
                'content' => 'folder.showfolder', // View konten utama
                'title' => $folder->name, // Judul halaman
                'folder' => $folder,
                'subTopic' => $subTopic,
                'section' => $section,
                'course' => $course,
                'files' => $folder->files_save,
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
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLFolder $mDLFolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLFolder $mDLFolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLFolder $mDLFolder)
    {

    }
}
