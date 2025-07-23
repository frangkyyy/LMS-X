<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\MDLFolder;
use Illuminate\Http\Request;
use App\Models\MDLLearningStyles;
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
        $dimensions = MDLLearningStyles::with('options')->get();
        $subTopics = CourseSubtopik::all();



//            $data = [
//                'menu' => 'menu.v_menu_admin',
//                'content' => 'labels.create',
//                'subTopics' => $subTopics,
//                'learningStyles' =>  $learningStyles,
//                'count_user' => DB::table('users')->count(),
//            ];

//            return view('layouts.v_template', $data);
        return view('folder.create', compact('dimensions', 'subTopics','subTopic'));
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
            'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,zip,rar|max:' . config('app.max_file_size', 5120),
            'dimension_options' => 'required|array|min:1',
            'dimension_options.*' => 'exists:opsi_dimensi,id',
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
                $folder = DB::transaction(function () use ($validated) {
                    // Create folder
                    $folder = MDLFolder::create([
                        'name' => $validated['name'],
                        'description' => $validated['description'],
                        'sub_topic_id' => $validated['sub_topic_id'],
                        // Consider removing if unused
                    ]);
                    $folder->options()->sync($validated['dimension_options']);
                    Log::info('Synced dimension options to mdl_folder_style', [
                        'folder_id' => $folder->id,
                        'dimension_options' => $validated['dimension_options']
                    ]);

                    return $folder;
                });

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
                ->with('success',  ' folder berhasil disimpan!');        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to create folder or folder: ' . $e->getMessage());

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
                'options',
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
                'options' => $folder->options,
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
    public function edit($id)
    {
        try {
            // Load the folder with related data
            $folder = MDLFolder::with(['sub_topic', 'options', 'files_save'])->findOrFail($id);
            $subTopic = $folder->sub_topic;
            $dimensions = MDLLearningStyles::with('options')->get();
            $subTopics = CourseSubtopik::all();

            return view('folder.edit', compact('folder', 'subTopic', 'dimensions', 'subTopics'));
        } catch (\Exception $e) {
            \Log::error('Failed to load folder edit form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load folder edit form. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLFolder $id)
    {
        // Log request data for debugging
        \Log::info('Request data for folder update:', $request->all());

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:' . config('app.max_file_size', 5120),
            'dimension' => 'nullable|array', // Optional, enforced by JavaScript
            'dimension.*' => 'exists:mdl_learning_styles,id',
            'dimension_options' => 'required|array|min:1', // Required per form
            'dimension_options.*' => 'exists:opsi_dimensi,id',
            'files_to_delete' => 'nullable|string',
        ], [
            'name.required' => 'Nama folder wajib diisi.',
            'sub_topic_id.required' => 'Sub-topik wajib dipilih.',
            'dimension_options.required' => 'Pilih setidaknya satu opsi dimensi.',
            'dimension_options.min' => 'Pilih setidaknya satu opsi dimensi.',
            'files.*.mimes' => 'Format file tidak didukung. Gunakan PDF, DOC(X), PPT(X), JPG, atau PNG.',
            'files.*.max' => 'Ukuran file terlalu besar. Maksimum 5MB.',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            \Log::warning('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get validated data
        $validated = $validator->validated();
        \Log::debug('Validated data for update:', $validated);

        try {
            // Start a database transaction
            $folder = DB::transaction(function () use ($request, $validated, $id) {
                // Update folder details
                $id->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'sub_topic_id' => $validated['sub_topic_id'],
                ]);
                \Log::info('Updated folder details', ['folder_id' => $id->id]);

                // Sync dimension options
                $id->options()->sync($validated['dimension_options']);
                \Log::info('Synced dimension options to mdl_folder_style', [
                    'folder_id' => $id->id,
                    'dimension_options' => $validated['dimension_options'],
                ]);

                // Process files to delete
                if (!empty($validated['files_to_delete'])) {
                    $filesToDelete = json_decode($validated['files_to_delete'], true);
                    \Log::debug('Files to delete:', [$filesToDelete]);
                    if (is_array($filesToDelete) && !empty($filesToDelete)) {
                        foreach ($filesToDelete as $fileId) {
                            $file = MDLFileSave::where('folder_id', $id->id)->find($fileId);
                            if ($file) {
                                if (Storage::disk('public')->exists($file->file_path)) {
                                    Storage::disk('public')->delete($file->file_path);
                                    \Log::info('Deleted file from storage', ['file_id' => $fileId, 'file_path' => $file->file_path]);
                                }
                                $file->delete();
                                \Log::info('Deleted file from database', ['file_id' => $fileId]);
                            }
                        }
                    }
                }

                // Process new uploaded files
                if ($request->hasFile('files')) {
                    foreach ($request->file('files') as $file) {
                        // Sanitize and generate unique file name
                        $originalName = $file->getClientOriginalName();
                        $sanitizedName = preg_replace('/[^A-Za-z0-9\-\\.]/', '', str_replace(' ', '-', $originalName));
                        $fileName = time() . '_' . $sanitizedName;
                        $filePath = $file->storeAs('uploads/folders', $fileName, 'public');
                        $fileSize = $file->getSize();

                        // Save file metadata
                        MDLFileSave::create([
                            'folder_id' => $id->id,
                            'name' => $originalName,
                            'description' => null,
                            'file_path' => $filePath,
                            'size' => $fileSize,
                        ]);
                        \Log::info('Uploaded new file', [
                            'folder_id' => $id->id,
                            'file_name' => $originalName,
                            'file_path' => $filePath,
                            'size' => $fileSize,
                        ]);
                    }
                }

                return $id;
            });

            // Load sub-topic and section for redirect
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            $section = $subTopic->section;
            if (!$section || !$section->course_id) {
                \Log::error('Invalid section or course_id', ['sub_topic_id' => $validated['sub_topic_id']]);
                throw new \Exception('Section atau course tidak ditemukan.');
            }

            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', 'Folder berhasil diperbarui!');
        } catch (\Exception $e) {
            // Log detailed error
            \Log::error('Failed to update folder: ' . $e->getMessage(), [
                'folder_id' => $id->id,
                'exception' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Gagal memperbarui folder: ' . $e->getMessage())->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLFolder  $mDLFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $folder = MDLFolder::findOrFail($id);

            DB::beginTransaction();

            // Delete associated files from storage and database
            $files = MDLFileSave::where('folder_id', $folder->id)->get();
            foreach ($files as $file) {
                if ($file->file_path) {
                    Storage::delete('public/uploads/folders/' . basename($file->file_path));
                }
                $file->delete();
                \Log::info('File deleted from folder', ['file_id' => $file->id, 'folder_id' => $folder->id]);
            }

            // Detach dimension options from pivot table
            $folder->options()->detach();
            \Log::info('Detached dimension options from mdl_folder_style', ['folder_id' => $folder->id]);

            // Delete the folder from database
            $folder->delete();
            \Log::info('Folder deleted successfully', ['folder_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Folder berhasil dihapus!'
                ]);
            }

            // Redirect to courses.topics if subTopic is null
            if (!$folder->subTopic) {
                \Log::warning('Subtopic not found for folder', ['folder_id' => $id]);
                return redirect()->route('courses.topics', [$folder->subTopic->section->course_id ?? 1])
                    ->with('success', 'Folder berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            return redirect()->route('sections.show', [
                $folder->subTopic->section->course_id,
                $folder->subTopic->section->id
            ])->with('success', 'Folder berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to delete folder: ' . $e->getMessage(), ['folder_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus folder: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus folder. Silakan coba lagi.']);
        }
    }
}
