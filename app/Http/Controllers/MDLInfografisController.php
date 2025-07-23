<?php

namespace App\Http\Controllers;

use App\Models\MDLInfografis;
use App\Models\CourseSubtopik;
use App\Models\DimensionOption;
use App\Models\MDLLearningStyles;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MDLInfografisController extends Controller
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
        return view('infografis.create', compact('dimensions', 'subTopics','subTopic'));
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
            // Validasi input sesuai form create.blade.php
            $validated = $request->validate([
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'required|array',
                'file_upload.*' => 'file|mimetypes:video/mp4,image/jpeg,image/png|max:5120', // Max 5MB
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
            ]);


            // Ambil sub_topic
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);

            $uploadedInfografis = [];

            foreach ($request->file('file_upload') as $uploadedFile) {
                // Generate unique filename
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();

                // Store file in storage/app/public/infografis
                $path = $uploadedFile->storeAs('public/infografis', $filename);

                // Simpan data ke database
                $infografisRecord = MDLInfografis::create([
                    'sub_topic_id' => $validated['sub_topic_id'],
                    'file_path' => 'infografis/' . $filename, // Path relatif
                    'created_at' => now(),
                ]);

                // Sync dimension options
                $infografisRecord->options()->sync($validated['dimension_options']);
                Log::info('Synced dimension options to mdl_infografis_style', [
                    'infografis_id' => $infografisRecord->id,
                    'dimension_options' => $validated['dimension_options']
                ]);

                $uploadedInfografis[] = $infografisRecord;
            }

            // Redirect dengan pesan sukses
            $section = $subTopic->section;
            return redirect()->route('sections.show', [$section->course_id, $section->id])
                ->with('success', count($uploadedInfografis) . ' infografis berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Failed to store infografis: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan infografis: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function show(MDLInfografis $mDLInfografis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infografis = MDLInfografis::with('options')->findOrFail($id);
        $subTopic = CourseSubtopik::findOrFail($infografis->sub_topic_id);
        $dimensions = MDLLearningStyles::with('options')->get();

        return view('infografis.edit', compact('infografis', 'subTopic', 'dimensions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLInfografis $mDLInfografis)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'sub_topic_id' => 'required|exists:mdl_course_subtopik,id',
                'file_upload' => 'nullable|file|mimetypes:video/mp4,image/jpeg,image/png|max:5120',
                'dimension_options' => 'required|array|min:1',
                'dimension_options.*' => 'exists:opsi_dimensi,id',
                'remove_existing_file' => 'sometimes|boolean',
            ]);

            // Update sub_topic_id
            $mDLInfografis->sub_topic_id = $validated['sub_topic_id'];

            // Handle file removal if requested
            if ($request->has('remove_existing_file') && $request->input('remove_existing_file')) {
                // Delete old file if it exists
                if ($mDLInfografis->getRawOriginal('file_path') && Storage::exists('public/' . $mDLInfografis->getRawOriginal('file_path'))) {
                    Storage::delete('public/' . $mDLInfografis->getRawOriginal('file_path'));
                }
                $mDLInfografis->file_path = null;
            }

            // Handle new file upload if provided
            if ($request->hasFile('file_upload')) {
                // Delete old file if it exists
                if ($mDLInfografis->getRawOriginal('file_path') && Storage::exists('public/' . $mDLInfografis->getRawOriginal('file_path'))) {
                    Storage::delete('public/' . $mDLInfografis->getRawOriginal('file_path'));
                }

                // Store new file
                $uploadedFile = $request->file('file_upload');
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                $path = $uploadedFile->storeAs('public/infografis', $filename);

                // Update file_path
                $mDLInfografis->file_path = 'infografis/' . $filename;
            }

            // Save the infografis
            $mDLInfografis->save();

            // Sync dimension options
            $mDLInfografis->options()->sync($validated['dimension_options']);
            \Log::info('Updated infografis and synced dimension options', [
                'infografis_id' => $mDLInfografis->id,
                'dimension_options' => $validated['dimension_options']
            ]);

            // Redirect to section show page
            $subTopic = CourseSubtopik::findOrFail($validated['sub_topic_id']);
            return redirect()->route('sections.show', [$subTopic->section->course_id, $subTopic->section->id])
                ->with('success', 'Infografis updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Failed to update infografis: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update infografis: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLInfografis  $mDLInfografis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $infografis = MDLInfografis::findOrFail($id);

            DB::beginTransaction();

            // Hapus file dari storage
            if ($infografis->file_path) {
                Storage::delete('public/' . $infografis->file_path);
            }

            // Hapus entri pivot di mdl_infografis_style
            $infografis->options()->detach();

            // Hapus infografis dari database
            $infografis->delete();

            Log::info('Infografis deleted successfully', ['infografis_id' => $id]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Infografis berhasil dihapus!'
                ]);
            }

            // Redirect ke halaman kursus jika subTopic null
            if (!$infografis->subTopic) {
                Log::warning('Subtopic not found for infografis', ['infografis_id' => $id]);
                return redirect()->route('courses.topics', [$infografis->subTopic->section->course_id ?? 1])
                    ->with('success', 'Infografis berhasil dihapus, tetapi subtopic tidak ditemukan.');
            }

            return redirect()->route('sections.show', [
                $infografis->subTopic->section->course_id,
                $infografis->subTopic->section->id
            ])->with('success', 'Infografis berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete infografis: ' . $e->getMessage(), ['infografis_id' => $id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus infografis: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal menghapus infografis. Silakan coba lagi.']);
        }
    }

}
