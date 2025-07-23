<?php

namespace App\Http\Middleware;

use App\Models\MDLUserLearningStyles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureILSCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Bypass ILS untuk Admin (id_role: 1) dan Guru (id_role: 2)
            if ($user->id_role == 1 || $user->id_role == 2) {
                return $next($request);
            }

            // Bypass untuk route course.index
            if ($request->routeIs('course.index')) {
                return $next($request);
            }

            // Cek ILS untuk Mahasiswa (id_role: 3)
            if ($user->id_role == 3) {
                $hasCompletedILS = MDLUserLearningStyles::where('user_id', $user->id)->exists();
                if (!$hasCompletedILS && !$request->is('kuesioner-ils/*')) {
                    return redirect()->route('ils.ils_kuesioner_processing')->with('error', 'Silakan selesaikan kuesioner ILS.');
                }
            }
        }

        return $next($request);
    }
}
