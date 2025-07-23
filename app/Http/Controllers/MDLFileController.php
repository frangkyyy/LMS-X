<?php

namespace App\Http\Controllers;

use App\Models\MDLFiles;
use App\Models\CourseSubtopik;
use App\Models\MDLLearningStyles;
use App\Models\DimensionOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MDLFileController extends Controller
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
        return view('files.create', compact('dimensions', 'subTopics','subTopic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'required|array',
                'file_upload.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,zip,rar|max:5120',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $uploadedFiles = [];
            foreach ($request->file('file_upload') as $uploadedFile) {
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();

                // Simpan file ke storage/public/files
                $path = $uploadedFile->storeAs('public/files', $filename);

                $fileRecord = MDLFiles::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'file_path' => 'files/' . $filename, // Perhatikan perubahan disini
                    'original_filename' => $uploadedFile->getClientOriginalName(),
                ]);

                $uploadedFiles[] = $fileRecord;
            }

            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', count($uploadedFiles) . ' file berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan file:', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function storeinfografis(Request $request)
    {
        try {
            // Validasi input sesuai form createinfografis.blade.php
            $validated = $request->validate([
                'learning_style_id' => 'required|exists:opsi_dimensi,id',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'required|array',
                'file_upload.*' => 'file|mimetypes:video/mp4,image/jpeg,image/png|max:5120', // Max 5MB
            ]);

            // Ambil sub_topic
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $uploadedFiles = [];
            foreach ($request->file('file_upload') as $uploadedFile) {
                // Generate unique filename
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();

                // Store file in storage/app/public/files
                $path = $uploadedFile->storeAs('public/files', $filename);

                // Simpan data ke database
                $fileRecord = MDLFiles::create([
                    'name' => $uploadedFile->getClientOriginalName(), // Nama file asli
                    'description' => 'Infografis untuk ' . $subTopic->title, // Deskripsi default
                    'learning_style_id' => $validated['learning_style_id'], // Pastikan ini 1 (visual)
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'file_path' => 'files/' . $filename, // Path relatif
                    'original_filename' => $uploadedFile->getClientOriginalName(),
                    'created_at' => now(),
                ]);

                $uploadedFiles[] = $fileRecord;
            }

            // Redirect dengan pesan sukses
            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', count($uploadedFiles) . ' infografis berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan infografis: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = MDLFiles::with('options')->findOrFail($id);
        $subTopic = CourseSubtopik::findOrFail($file->sub_topic_id);
        $dimensions = MDLLearningStyles::with('options')->get();

        return view('files.edit', compact('file', 'subTopic', 'dimensions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'nullable|array',
                'file_upload.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:5120',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);

            $file = MDLFiles::findOrFail($id);
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            // Update basic file information
            $file->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'sub_topic_id' => $validated['sub_topic_id'],
            ]);

            // Handle file upload if provided
            if ($request->hasFile('file_upload')) {
                // Delete old file
                if ($file->file_path) {
                    Storage::delete('public/' . $file->file_path);
                }

                foreach ($request->file('file_upload') as $uploadedFile) {
                    $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                    $path = $uploadedFile->storeAs('public/files', $filename);

                    $file->update([
                        'file_path' => 'files/' . $filename,
                        'original_filename' => $uploadedFile->getClientOriginalName(),
                    ]);
                }
            }

            // Sync dimension options
            $file->options()->sync($validated['dimension_options']);
            Log::info('Updated dimension options for file', [
                'file_id' => $file->id,
                'dimension_options' => $validated['dimension_options']
            ]);

            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', 'File berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update file: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $file = MDLFiles::findOrFail($id);

            DB::beginTransaction();

            // Hapus file dari storage
            if ($file->file_path) {
                Storage::delete('public/files/' . basename($file->file_path));
            }

            // Hapus entri pivot di mdl_files_style
            $file->options()->detach();

            // Hapus file dari database
            $file->delete();

            Log::info('File deleted successfully', ['file_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil dihapus!'
                ]);
            }

            // Redirect ke halaman kursus jika subTopic null
            if (!$file->subTopic) {
                Log::warning('Subtopic not found for file', ['file_id' => $id]);
                return redirect()->route('courses.topics', [$file->subTopic->section->course_id ?? 1])
                    ->with('success', 'File berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            return redirect()->route('sections.show', [
                $file->subTopic->section->course_id,
                $file->subTopic->section->id
            ])->with('success', 'File berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete file: ' . $e->getMessage(), ['file_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus file: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus file. Silakan coba lagi.']);
        }
    }
}
