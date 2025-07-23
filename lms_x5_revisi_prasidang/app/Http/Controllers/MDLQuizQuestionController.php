<?php

namespace App\Http\Controllers;

use App\Models\MDLQuiz;
use App\Models\MDLQuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MDLQuizQuestionController extends Controller
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
    public function create($quiz_id)
    {
        $quiz = MDLQuiz::findOrFail($quiz_id);
        return view('question.create', compact('quiz'));
    }

    /**
     * Store questions for a specific quiz.
     */
    public function store(Request $request, $quiz_id)
    {

        $quiz = MDLQuiz::findOrFail($quiz_id);
        $validated = $request->validate([
            'quiz_id' => 'sometimes|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.poin' => 'required|integer|min:0',
            'questions.*.options_a' => 'required|string',
            'questions.*.options_b' => 'required|string',
            'questions.*.options_c' => 'required|string',
            'questions.*.options_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D',
        ]);

        try {
            // Update quiz title if provided
            if ($request->has('quiz_title')) {
                $quiz->title = $request->input('quiz_title');
                $quiz->save();
            }

            foreach ($validated['questions'] as $questionData) {
                MDLQuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                    'poin' => $questionData['poin'],
                    'options_a' => $questionData['options_a'],
                    'options_b' => $questionData['options_b'],
                    'options_c' => $questionData['options_c'],
                    'options_d' => $questionData['options_d'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            }

            return redirect()->route('quizs.show', $quiz->id)->with('success', 'Questions added successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to add questions: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add questions: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLQuizQuestion  $mDLQuizQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(MDLQuizQuestion $mDLQuizQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLQuizQuestion  $mDLQuizQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLQuizQuestion $mDLQuizQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLQuizQuestion  $mDLQuizQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLQuizQuestion $mDLQuizQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLQuizQuestion  $mDLQuizQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLQuizQuestion $mDLQuizQuestion)
    {
        //
    }
}
