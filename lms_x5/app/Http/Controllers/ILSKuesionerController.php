<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MDLLearningStyles;
use App\Models\MDLUserLearningStyles;

class ILSKuesionerController extends Controller
{
    public function showProcessing()
    {
        return view('ils.ils_kuesioner_processing');
    }

    public function showPerception()
    {
        return view('ils.ils_kuesioner_perception');
    }

    public function showInput()
    {
        return view('ils.ils_kuesioner_input');
    }

    public function showUnderstanding()
    {
        return view('ils.ils_kuesioner_understanding');
    }

    private function storeAnswers(Request $request, string $nextRoute)
    {
        $validatedData = $request->validate(array_fill_keys(array_keys($request->except('_token')), 'required'));
        session(['answers' => array_merge(session('answers', []), $validatedData)]);
        return redirect()->route($nextRoute);
    }

    public function storeProcessing(Request $request)
    {
        return $this->storeAnswers($request, 'ils.ils_kuesioner_perception');
    }

    public function storePerception(Request $request)
    {
        return $this->storeAnswers($request, 'ils.ils_kuesioner_input');
    }

    public function storeInput(Request $request)
    {
        return $this->storeAnswers($request, 'ils.ils_kuesioner_understanding');
    }

    public function storeUnderstanding(Request $request)
    {
        $this->storeAnswers($request, 'ils.ils_score');

        $answers = session('answers');
        $userId = auth()->user()->id;

        $categories = [
            'ACT/REF' => ['Active' => [1,2,3,4,5,6,7,8,9,10,11], 'Reflective' => [1,2,3,4,5,6,7,8,9,10,11]],
            'SNS/INT' => ['Sensing' => [12,13,14,15,16,17,18,19,20,21,22], 'Intuitive' => [12,13,14,15,16,17,18,19,20,21,22]],
            'VIS/VRB' => ['Visual' => [23,24,25,26,27,28,29,30,31,32,33], 'Verbal' => [23,24,25,26,27,28,29,30,31,32,33]],
            'SEQ/GLO' => ['Sequential' => [34,35,36,37,38,39,40,41,42,43,44], 'Global' => [34,35,36,37,38,39,40,41,42,43,44]],
        ];

        $scores = [];

        foreach ($categories as $dimension => $types) {
            $styleKeys = array_keys($types);
            $a_style = $styleKeys[0]; // misalnya "Visual"
            $b_style = $styleKeys[1]; // misalnya "Verbal"

            $a_count = collect($types[$a_style])->sum(fn($q) => ($answers["q$q"] ?? "") === "A" ? 1 : 0);
            $b_count = collect($types[$b_style])->sum(fn($q) => ($answers["q$q"] ?? "") === "B" ? 1 : 0);

            $dominantCategory = ($a_count >= $b_count) ? "A" : "B";
            $scoreValue = abs($a_count - $b_count);
            $styleName = ($dominantCategory === "A") ? $a_style : $b_style;

            $category = 'Balanced';
            if (in_array($scoreValue, [5, 7])) {
                $category = 'Moderate';
            } elseif (in_array($scoreValue, [9, 11])) {
                $category = 'Strong';
            }

            MDLUserLearningStyles::updateOrCreate(
                ['user_id' => $userId, 'dimension' => $dimension],
                [
                    'a_count' => $a_count,
                    'b_count' => $b_count,
                    'final_score' => "$scoreValue$styleName",
                    'category' => $category
                ]
            );

            $scores[$dimension] = [
                'a_count' => $a_count,
                'b_count' => $b_count,
                'final_score' => "$scoreValue$styleName",
                'category' => $category
            ];
        }

        // Ambil gaya dominan dari setiap dimensi
        $dimensions = ['ACT/REF', 'SNS/INT', 'VIS/VRB', 'SEQ/GLO'];
        $finalStyles = [];

            foreach ($dimensions as $dimension) {
                $style = $scores[$dimension]['final_score']; // contoh: 5Active
                // ambil bagian teks setelah angka
                preg_match('/[A-Za-z]+$/', $style, $matches);
                $finalStyles[] = strtolower($matches[0]); // jadi: active, sensing, visual, sequential
            }

            // Gabungkan menjadi satu string kombinasi
            $learningStyleCombination = implode('_', $finalStyles); // contoh: active_sensing_visual_sequential
            session(['learning_style_combination' => 'learning_styles_combined.' . $learningStyleCombination]);

        return redirect()->route('ils.ils_score')->with('success', 'Kuesioner berhasil disimpan!');
    }

    public function showScore()
    {
        $userId = auth()->user()->id;
        $userLearningStyles = MDLUserLearningStyles::where('user_id', $userId)->get();

        $scores = [];

        $dimensionNames = [
            'ACT/REF' => ['Active', 'Reflective'],
            'SNS/INT' => ['Sensing', 'Intuitive'],
            'VIS/VRB' => ['Visual', 'Verbal'],
            'SEQ/GLO' => ['Sequential', 'Global'],
        ];

        foreach ($userLearningStyles as $style) {
            $dominantCategory = ($style->a_count >= $style->b_count) ? "A" : "B";
            $scoreValue = abs($style->a_count - $style->b_count);
            $styleName = ($dominantCategory === "A") ? $dimensionNames[$style->dimension][0] : $dimensionNames[$style->dimension][1];

            $category = 'Balanced';
            if (in_array($scoreValue, [5, 7])) {
                $category = 'Moderate';
            } elseif (in_array($scoreValue, [9, 11])) {
                $category = 'Strong';
            }

            $scores[$style->dimension] = [
                'a_count' => $style->a_count,
                'b_count' => $style->b_count,
                'final_score' => "$scoreValue$styleName",
                'category' => $category
            ];
        }

        return view('ils.ils_score', compact('scores'));
    }
}
