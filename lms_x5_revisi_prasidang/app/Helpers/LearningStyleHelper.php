<?php

namespace App\Helpers;

use App\Models\MDLUserLearningStyles;
use Illuminate\Support\Facades\Auth;

class LearningStyleHelper
{
    public static function getUserLearningStyleCombination()
    {
        $userId = Auth::id();
        $styles = MDLUserLearningStyles::where('user_id', $userId)->get()->keyBy('dimension');

        $dimensions = ['ACT/REF', 'SNS/INT', 'VIS/VRB', 'SEQ/GLO'];
        $combination = [];

        foreach ($dimensions as $dimension) {
            $style = $styles[$dimension] ?? null;
            if (!$style || !$style->final_score) return null;

            // Ambil bagian nama gaya belajar dari final_score, misalnya: "1Reflective" → "Reflective"
            if (preg_match('/\d*(\D+)/', $style->final_score, $matches)) {
                $combination[] = strtolower($matches[1]);
            } else {
                return null; // jika tidak match
            }
        }

        return implode('_', $combination); // contoh hasil: reflective_intuitive_verbal_global
    }

    public static function getStyleSlug($styleCombination)
    {
        $map = [
            'active_sensing_visual_sequential' => 'acsensvisseq',
            'active_sensing_verbal_sequential' => 'acsensverseq',
            'active_intuitive_visual_sequential' => 'acintvisseq',
            'active_intuitive_verbal_sequential' => 'acintverseq',
            'reflective_sensing_visual_sequential' => 'refsensvisseq',
            'reflective_sensing_verbal_sequential' => 'refsensverseq',
            'reflective_intuitive_visual_sequential' => 'refintvisseq',
            'reflective_intuitive_verbal_sequential' => 'refintverseq',
            'active_sensing_visual_global' => 'acsensvisglob',
            'active_sensing_verbal_global' => 'acsensverglob',
            'active_intuitive_visual_global' => 'acintvisglob',
            'active_intuitive_verbal_global' => 'acintverglob',
            'reflective_sensing_visual_global' => 'refsensvisglob',
            'reflective_sensing_verbal_global' => 'refsensverglob',
            'reflective_intuitive_visual_global' => 'refintvisglob',
            'reflective_intuitive_verbal_global' => 'refintverglob',
        ];

        return $map[$styleCombination] ?? 'default';
    }

    public static function getFormattedLearningStyle()
    {
        $userId = Auth::id();
        $styles = MDLUserLearningStyles::where('user_id', $userId)->get();

        if ($styles->isEmpty()) {
            return 'Belum ada data gaya belajar';
        }

        // Ambil hanya nama gaya belajar dari final_score (misalnya "1Reflective" → "Reflective")
        $styleNames = $styles->map(function ($item) {
            return preg_replace('/^\d+/', '', $item->final_score); // hapus angka di depan
        });

        return $styleNames->implode('-'); // gabung dengan tanda "-"
    }

}
