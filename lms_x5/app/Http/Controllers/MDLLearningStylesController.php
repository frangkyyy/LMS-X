<?php

namespace App\Http\Controllers;

use App\Models\MDLLearningStyles;
use App\Helpers\LearningStyleHelper;
use Illuminate\Http\Request;

class MDLLearningStylesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id, $topik, $section_id)
    {
        $style = LearningStyleHelper::getUserLearningStyleCombination();
        // Contoh hasil: reflective_intuitive_verbal_global

        $viewPath = "learning_styles_combined.$topik.$style.index";

        if (View::exists($viewPath)) {
            return view($viewPath, compact('course_id', 'topik', 'section_id'));
        }

        return view('learning_styles_combined.default'); // fallback kalau tidak ditemukan
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLLearningStyles  $mDLLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function show(MDLLearningStyles $mDLLearningStyles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLLearningStyles  $mDLLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLLearningStyles $mDLLearningStyles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLLearningStyles  $mDLLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLLearningStyles $mDLLearningStyles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLLearningStyles  $mDLLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLLearningStyles $mDLLearningStyles)
    {
        //
    }
}
