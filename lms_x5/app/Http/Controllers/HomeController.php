<?php

namespace App\Http\Controllers;
use App\Models\MDLCourse;
use App\Models\MDLQuiz;
use App\Models\MDLAssign;
use App\Models\MDLAssignSubmission;
use App\Models\MDLForum;
use App\Models\MDLUserLearningStyles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $courses = MDLCourse::where('visible', 1)->get();

        $quizCount = MDLQuiz::count();

        // Update last login time
        $user->last_login_at = now()->setTimezone(config('app.timezone'));
        $user->save();;

        // Ambil semua Assignment + Submission user
        $assignments = MDLAssign::with(['submission' => function ($query) use ($user) {
            $query->where('user_id', $user->id);  // Hanya ambil yang submit oleh user
        }])->get();

        $forums = MDLForum::all();

        $lastLogin = $user->last_login_at
            ? $user->last_login_at->format('d M Y H:i')
            : 'Belum Pernah Login';

        // Periksa apakah user sudah menyelesaikan kuesioner ILS
        $hasCompletedILS = MDLUserLearningStyles::where('user_id', $user->id)->exists();

        if (!$hasCompletedILS) {
            return redirect()->route('ils.ils_kuesioner_processing');
        }

        // Ambil data gaya belajar berdasarkan final_score dan category
        $learningStyles = MDLUserLearningStyles::where('user_id', $user->id)->get();

        $studentStyles = [];
        foreach ($learningStyles as $style) {
            preg_match('/[A-Za-z]+$/', $style->final_score, $matches);
            $studentStyles[] = strtolower($matches[0] ?? '');
        }

        // Get assignments that match user's learning style or have no specific style
        $assignments = MDLAssign::with(['submission' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
            ->where(function($query) use ($studentStyles) {
                $query->whereIn('learning_style', $studentStyles)
                    ->orWhereNull('learning_style');
            })
            ->get();

        $dimensionLabels = [
            'ACT/REF' => ['Active', 'Reflective'],
            'SNS/INT' => ['Sensing', 'Intuitive'],
            'VIS/VRB' => ['Visual', 'Verbal'],
            'SEQ/GLO' => ['Sequential', 'Global'],
        ];

        $scores = [];

        foreach ($learningStyles as $style) {
            $dimension = $style->dimension;

            // Ambil nama gaya dari final_score, contoh: "5Active" -> "Active"
            preg_match('/[A-Za-z]+$/', $style->final_score, $matches);
            $label = $matches[0] ?? $dimensionLabels[$dimension][0];

            $scores[$dimension] = [
                'label' => $label,
                'category' => $style->category,
            ];
        }

        // Di dalam method index() HomeController.php, sebelum return view
        $filteredQuizzes = MDLQuiz::where(function($query) use ($studentStyles) {
            $query->whereIn('learning_style', $studentStyles)
                ->orWhereNull('learning_style');
        })->count();

        $menuItems = [
            [
                'title' => 'Dashboard',
                'route' => route('home'),
                'icon' => 'fas fa-layer-group',
                'active' => request()->is('home'),
            ],
            [
                'section' => 'Navigasi',
            ],
            [
                'title' => 'Course',
                'route' => route('course.index'),
                'icon' => 'fas fa-book',
                'active' => request()->is('course*'),
            ],
            [
                'title' => 'My Active Courses',
                'icon' => 'fas fa-book-open',
                'submenu' => $courses->map(function ($course) {
                    return [
                        'title' => $course->name,
                        'route' => route('course.topikmatkul', $course->id),
                        'active' => request()->is('course/' . $course->id . '/*'),
                    ];
                })->toArray(),
            ],
        ];

        $data = [
            'count_user' => DB::table('users')->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'content.view_dashboard',
            'scores'     => $scores,
            'courses' => $courses,
            'quizCount'  => $quizCount,
            'filteredQuizzes' => $filteredQuizzes, // Tambahkan ini
            'assignments' => $assignments,
            'forums' => $forums,
            'last_login' => $lastLogin,
            'studentStyles' => $studentStyles, // Tambahkan ini
            'menuItems' => $menuItems,
        ];

        return view('layouts.v_template', $data);
    }
}
