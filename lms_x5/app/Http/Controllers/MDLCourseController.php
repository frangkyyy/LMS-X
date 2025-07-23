<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\MDLSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MDLCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Jika dosen, tampilkan semua course tanpa filter visible
        if ($user->id_role == 2) {
            $courses = MDLCourse::all();
        } else {
            $courses = MDLCourse::where('visible', 1)->get();
        }

        // Mengambil hanya kursus yang visible
        $courses = MDLCourse::where('visible', 1)->get();

        $data = [
            'count_user' => Auth::user()->count(), // Menghitung jumlah user jika diperlukan
            'menu' => 'menu.v_menu_admin',
            'content' => 'course.index', // Pastikan ini sesuai dengan tampilan yang dibuat
            'title' => $user->id_role == 2 ? 'All Courses' : 'My Course',
            'courses' => $courses, // Kirim data ke tampilan
        ];

        // Jika request AJAX, kirim data sebagai JSON untuk DataTables
        if ($request->ajax()) {
            return Datatables::of($courses)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user) {
                    if ($user->id_role == 2) {
                        $btn = '<div data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 editCourse"><i class="fi-rr-edit"></i></div>';
                        $btn .= ' <div data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse"><i class="fi-rr-trash"></i></div>';
                        return $btn;
                    }
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.v_template', $data);
    }

    public function indexdosen(Request $request)
    {
        $user = Auth::user();

        // Jika dosen, tampilkan semua course tanpa filter visible
        if ($user->id_role == 2) {
            $courses = MDLCourse::all();
        } else {
            $courses = MDLCourse::where('visible', 1)->get();
        }

        // Mengambil hanya kursus yang visible
        $courses = MDLCourse::where('visible', 1)->get();

        $data = [
            'count_user' => Auth::user()->count(), // Menghitung jumlah user jika diperlukan
            'menu' => 'menu.v_menu_admin',
            'content' => 'course_dosen.index', // Pastikan ini sesuai dengan tampilan yang dibuat
            'title' => $user->id_role == 2 ? 'All Courses' : 'My Course',
            'courses' => $courses, // Kirim data ke tampilan
        ];

        // Jika request AJAX, kirim data sebagai JSON untuk DataTables
        if ($request->ajax()) {
            return Datatables::of($courses)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user) {
                    if ($user->id_role == 2) {
                        $btn = '<div data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 editCourse"><i class="fi-rr-edit"></i></div>';
                        $btn .= ' <div data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse"><i class="fi-rr-trash"></i></div>';
                        return $btn;
                    }
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.v_template', $data);
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
     * @param  \App\Models\MDLCourse  $mDLCourse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = MDLCourse::where('id', $id)->where('visible', 1)->firstOrFail();
        $sections = MDLSection::where('course_id', $id)->where('visible', 1)->get();

        return view('course.topikmatkul', [
            'menu' => 'menu.v_menu_admin',
            'content' => 'course.topikmatkul',
            'title' => $course->full_name,
            'course' => $course,
            'sections' => $sections,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MDLCourse  $mDLCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(MDLCourse $mDLCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MDLCourse  $mDLCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MDLCourse $mDLCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MDLCourse  $mDLCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(MDLCourse $mDLCourse)
    {
        //
    }
}
