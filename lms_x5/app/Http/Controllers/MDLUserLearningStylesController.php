<?php

namespace App\Http\Controllers;

use App\Models\MDLUserLearningStyles;
use Illuminate\Http\Request;

class MDLUserLearningStylesController extends Controller
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
        $userId = auth()->user()->id;
        $dimensions = ['ACT/REF', 'SNS/INT', 'VIS/VRB', 'SEQ/GLO'];

        foreach ($dimensions as $dimension) {
            $aCount = $request->input($dimension . '_a', 0);
            $bCount = $request->input($dimension . '_b', 0);
            $dominant = ($aCount >= $bCount) ? "A" : "B";
            $finalScore = abs($aCount - $bCount);

            // Tentukan kategori berdasarkan final_score
            if (in_array($finalScore, [1, 3])) {
                $category = 'Balanced';
            } elseif (in_array($finalScore, [5, 7])) {
                $category = 'Moderate';
            } else {
                $category = 'Strong';
            }

            MDLUserLearningStyles::create([
                'user_id' => $userId,
                'dimension' => $dimension,
                'a_count' => $aCount,
                'b_count' => $bCount,
                'final_score' => $finalScore . $dominant,
                'category' => $category, // Pastikan category ikut disimpan
            ]);
        }

        return redirect()->back()->with('success', 'Data successfully saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MDLUserLearningStyles  $mDLUserLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function show(MDLUserLearningStyles $mDLUserLearningStyles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLUserLearningStyles  $mDLUserLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLUserLearningStyles $mDLUserLearningStyles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLUserLearningStyles  $mDLUserLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLUserLearningStyles $mDLUserLearningStyles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLUserLearningStyles  $mDLUserLearningStyles
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLUserLearningStyles $mDLUserLearningStyles)
    {
        //
    }
}
