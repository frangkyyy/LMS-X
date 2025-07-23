<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MDLUserLearningStyles;
use App\Models\MDLQuizGrades;
use App\Models\MDLSection;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();

        $learningStyle = MDLUserLearningStyles::where('user_id', $userId)->first();

        $quizGrades = MDLQuizGrades::where('user_id', $userId)->get();
        $quizAttempts = $quizGrades->count();
        $maxScore = $quizGrades->max('grade') ?? 0;
        $avgScore = $quizGrades->avg('grade') ?? 0;

        return view('content.view_dashboard', compact('learningStyle', 'quizAttempts', 'maxScore', 'avgScore'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()

    {
        $studentCount = User::whereHas('role', function($query) {
            $query->where('name_role', 'Student');
        })->where('status', 'active')->count();

        $instructorCount = User::whereHas('role', function($query) {
            $query->where('name_role', 'Teacher');
        })->count();

        $users = User::with('role')->get();

        $courseCount = MDLCourse::count();
        $sectionCount=MDLSection::count();
        $data = [
        'student_count' => $studentCount,
        'instructor_count' => $instructorCount,
        'course_count' => $courseCount,
        'section_count' => $sectionCount,

        'users' => $users,
        'count_user' => DB::table('users')->count(),
        'menu'      => 'menu.v_menu_admin',
        'content'   => 'admin.dashboard'

    ];
        return view('layouts.v_template', $data);
    }

    public function index_dosen()

    {
        $data = [
            'count_user' => DB::table('users')->count(),
            'menu'      => 'menu.v_menu_admin',
            'content'   => 'content.data'

        ];
        return view('layouts.v_template', $data);
    }


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
