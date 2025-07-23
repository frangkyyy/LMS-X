<?php

namespace App\Http\Controllers;

use App\Models\MDLQuiz;
use App\Models\MDLQuizAttempts;
use Illuminate\Http\Request;

class MDLQuizAttemptsController extends Controller
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
     * @param  \App\Models\MDLQuizAttempts  $mDLQuizAttempts
     * @return \Illuminate\Http\Response
     */
    public function show(MDLQuizAttempts $mDLQuizAttempts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLQuizAttempts  $mDLQuizAttempts
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLQuizAttempts $mDLQuizAttempts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLQuizAttempts  $mDLQuizAttempts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLQuizAttempts $mDLQuizAttempts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLQuizAttempts  $mDLQuizAttempts
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLQuizAttempts $mDLQuizAttempts)
    {
        //
    }

    public function showParticipantQuiz($quizId)
    {
        // Retrieve quiz with related data
        $quiz = MDLQuiz::with(['sub_topic.section.course'])->findOrFail($quizId);

        $subTopic = $quiz->sub_topic;
        $section = $subTopic->section;
        $course = $section->course;

        return view('layouts.v_template', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'quiz.showgrade',
            'title' => 'Peserta Kuis: ' . $quiz->name,
            'quiz' => $quiz,

            'course' => $course,
            'section' => $section,
            'subTopic' => $subTopic,
        ]);
    }
}
