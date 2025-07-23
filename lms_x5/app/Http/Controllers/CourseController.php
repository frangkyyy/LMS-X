<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\User;
use App\Models\MDLSection;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count_user = DB::table('users')->count();
        $users = User::all();

        $data = [
            'count_user' => $count_user,
            'users' => $users,
            'courses' => MDLCourse::all(),
            'menu' => 'menu.v_menu_admin',
            'content' => 'Admin.Course.index'
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'count_user' => DB::table('users')->count(),
            'courses' => MDLCourse::all(),
            'menu' => 'menu.v_menu_admin',
            'content' => 'admin.course.create'
        ];
        return view('layouts.v_template', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Log::info('Request data received', $request->all());

        $request->validate([
            'full_name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'summary' => 'required|string',
            'cpmk' => 'nullable|string',
            'semester' => 'required|in:1,2,3',
            'visible' => 'required|boolean',
            'course_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'required|string',
            'start_day' => 'required|integer|between:1,31',
            'start_month' => 'required|string',
            'start_year' => 'required|integer|between:2023,2030',
            'start_time' => 'required',
            'enable_end_date' => 'nullable',
            'end_day' => 'required_if:enable_end_date,1|integer|between:1,31',
            'end_month' => 'required_if:enable_end_date,1|string',
            'end_year' => 'required_if:enable_end_date,1|integer|between:2023,2030',
            'end_time' => 'required_if:enable_end_date,1',
            'participants' => 'nullable|string',
        ]);

        // Combine start date and time
        $startDate = \Carbon\Carbon::createFromFormat(
            'Y F d H:i',
            "{$request->start_year} {$request->start_month} {$request->start_day} {$request->start_time}"
        );

        // Combine end date and time if enabled
        $endDate = null;
        if ($request->has('enable_end_date') && $request->end_day && $request->end_month && $request->end_year && $request->end_time) {
            $endDate = \Carbon\Carbon::createFromFormat(
                'Y F d H:i',
                "{$request->end_year} {$request->end_month} {$request->end_day} {$request->end_time}"
            );
        }

        // Upload image if present
        $imagePath = null;
        if ($request->hasFile('course_image')) {
            $imagePath = $request->file('course_image')->store('course_images', 'public');
        }

        // Parse participants
        $participants = $request->participants ? json_decode($request->participants, true) : [];
        Log::info('Parsed participants', ['participants' => $participants]);

        // Validate participants
        $validRoles = CourseUser::PARTICIPANT_ROLES;
        foreach ($participants as $participant) {
            if (!isset($participant['id']) || !isset($participant['name']) || !isset($participant['role'])) {
                Log::error('Invalid participant data', ['participant' => $participant]);
                return redirect()->back()->withErrors(['error' => 'Invalid participant data: Missing id, name, or role.']);
            }
            if (!is_numeric($participant['id']) || (int)$participant['id'] <= 0) {
                Log::error('Invalid participant ID', ['id' => $participant['id']]);
                return redirect()->back()->withErrors(['error' => 'Invalid participant ID: ' . $participant['id']]);
            }
            $participantRole = ucfirst(strtolower($participant['role']));
            if (!in_array($participantRole, $validRoles)) {
                Log::error('Invalid participant role', ['role' => $participant['role']]);
                return redirect()->back()->withErrors(['error' => 'Invalid participant role: ' . $participant['role']]);
            }
            // Verify user exists
            $user = User::find($participant['id']);
            if (!$user) {
                Log::error('User not found', ['user_id' => $participant['id']]);
                return redirect()->back()->withErrors(['error' => "User with ID {$participant['id']} not found."]);
            }
        }


        DB::beginTransaction();
        try {
            // Create the course
            $course = MDLCourse::create([
                'full_name' => $request->full_name,
                'short_name' => $request->short_name,
                'summary' => $request->summary,
                'cpmk' => $request->cpmk,
                'semester' => $request->semester,
                'visible' => $request->visible,
                'course_image' => $imagePath,
                'category' => $request->category,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            // Debug: Ensure course ID is valid
            if (!$course->id || !is_numeric($course->id) || (int)$course->id <= 0) {
                Log::error('Failed to create course: Invalid ID', ['course' => $course]);
                throw new \Exception('Failed to create course: Invalid ID');
            }
            Log::info('Course created', ['course_id' => $course->id]);

            // Create 10 default sections
            for ($i = 1; $i <= 10; $i++) {
                $section = MDLSection::create([
                    'course_id' => $course->id,
                    'title' => "Judul Topik $i",
                    'sort_order' => $i,
                ]);
                Log::info("Section created: ID {$section->id}, Course ID {$course->id}, Title: Judul Topik $i");
            }

            // Add participants to course_user table
            foreach ($participants as $participant) {

                $userId = (int) $participant['id'];
                $courseId = (int) $course->id;
                $participantRole = ucfirst(strtolower($participant['role']));

                if ($userId <= 0 || $courseId <= 0) {
                    Log::error('Invalid user_id or course_id', [
                        'user_id' => $userId,
                        'course_id' => $courseId,
                    ]);
                    throw new \Exception('Invalid user_id or course_id');
                }

                $courseUserData = [
                    'course_id' => $courseId,
                    'user_id' => $userId,
                    'participant_role' => $participantRole,
                ];
                Log::info('Attempting to create CourseUser entry', ['data' => $courseUserData]);

                try {
                    $courseUser = CourseUser::create($courseUserData);
                    Log::info("Participant added", [
                        'course_user_id' => $courseUser->id,
                        'course_id' => $course->id,
                        'user_id' => $userId,
                        'role' => $participantRole
                    ]);
                } catch (QueryException $e) {
                    Log::error('Failed to create CourseUser entry', [
                        'data' => $courseUserData,
                        'error' => $e->getMessage(),
                        'sql' => $e->getSql(),
                        'bindings' => $e->getBindings()
                    ]);
                    throw new \Exception('Failed to add participant: ' . $e->getMessage());
                }
            }

            DB::commit();
            return redirect()->route('coursesadmin.index')->with('success', 'Course, sections, and participants successfully added');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create course, sections, or participants: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Failed to create course, sections, or participants: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = MDLCourse::with('sections', 'users')->findOrFail($id);
        $data = [
            'count_user' => DB::table('users')->count(),
            'menu' => 'menu.v_menu_admin',
            'content' => 'Admin.Course.coursedetail',
            'course' => $course,
            'sections' => $course->sections ?? collect([]),
            'participants' => $course->users ?? collect([]),
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = MDLCourse::with('users')->findOrFail($id);
        $data = [
            'count_user' => DB::table('users')->count(),
            'course' => $course,
            'menu' => 'menu.v_menu_admin',
            'content' => 'admin.course.edit'
        ];
        return view('layouts.v_template', $data);
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

        Log::info('Update request data received', $request->all());

        $request->validate([
            'full_name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'summary' => 'required|string',
            'cpmk' => 'nullable|string',
            'semester' => 'required|in:1,2,3',
            'visible' => 'required|boolean',
            'course_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'required|string',
            'start_day' => 'required|integer|between:1,31',
            'start_month' => 'required|string',
            'start_year' => 'required|integer|between:2023,2030',
            'start_time' => 'required',
            'enable_end_date' => 'nullable',
            'end_day' => 'required_if:enable_end_date,1|integer|between:1,31',
            'end_month' => 'required_if:enable_end_date,1|string',
            'end_year' => 'required_if:enable_end_date,1|integer|between:2023,2030',
            'end_time' => 'required_if:enable_end_date,1',
            'participants' => 'nullable|string',
        ]);


        $startDate = \Carbon\Carbon::createFromFormat(
            'Y F d H:i',
            "{$request->start_year} {$request->start_month} {$request->start_day} {$request->start_time}"
        );


        $endDate = null;
        if ($request->has('enable_end_date') && $request->end_day && $request->end_month && $request->end_year && $request->end_time) {
            $endDate = \Carbon\Carbon::createFromFormat(
                'Y F d H:i',
                "{$request->end_year} {$request->end_month} {$request->end_day} {$request->end_time}"
            );
        }

        // Parse participants
        $participants = $request->participants ? json_decode($request->participants, true) : [];
        Log::info('Parsed participants', ['participants' => $participants]);

        // Validate participants
        $validRoles = CourseUser::PARTICIPANT_ROLES;
        foreach ($participants as $participant) {
            if (!isset($participant['id']) || !isset($participant['name']) || !isset($participant['role'])) {
                Log::error('Invalid participant data', ['participant' => $participant]);
                return redirect()->back()->withErrors(['error' => 'Invalid participant data: Missing id, name, or role.']);
            }
            if (!is_numeric($participant['id']) || (int)$participant['id'] <= 0) {
                Log::error('Invalid participant ID', ['id' => $participant['id']]);
                return redirect()->back()->withErrors(['error' => 'Invalid participant ID: ' . $participant['id']]);
            }
            $participantRole = ucfirst(strtolower($participant['role']));
            if (!in_array($participantRole, $validRoles)) {
                Log::error('Invalid participant role', ['role' => $participant['role']]);
                return redirect()->back()->withErrors(['error' => 'Invalid participant role: ' . $participant['role']]);
            }
            // Verify user exists
            $user = User::find($participant['id']);
            if (!$user) {
                Log::error('User not found', ['user_id' => $participant['id']]);
                return redirect()->back()->withErrors(['error' => "User with ID {$participant['id']} not found."]);
            }
        }


        DB::beginTransaction();
        try {
            // Find the course
            $course = MDLCourse::findOrFail($id);
            Log::info('Course found for update', ['course_id' => $course->id]);

            // Handle image upload
            $imagePath = $course->course_image;
            if ($request->hasFile('course_image')) {
                // Delete old image if exists
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                    Log::info('Old course image deleted', ['course_id' => $id, 'image_path' => $imagePath]);
                }
                $imagePath = $request->file('course_image')->store('course_images', 'public');
                Log::info('New course image uploaded', ['course_id' => $id, 'image_path' => $imagePath]);
            }

            // Update the course
            $course->update([
                'full_name' => $request->full_name,
                'short_name' => $request->short_name,
                'summary' => $request->summary,
                'cpmk' => $request->cpmk,
                'semester' => $request->semester,
                'visible' => $request->visible,
                'course_image' => $imagePath,
                'category' => $request->category,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
            Log::info('Course updated', ['course_id' => $course->id]);

            // Update participants
            CourseUser::where('course_id', $course->id)->delete();
            Log::info('Old participants removed', ['course_id' => $course->id]);

            foreach ($participants as $participant) {
                $userId = (int) $participant['id'];
                $courseId = (int) $course->id;
                $participantRole = ucfirst(strtolower($participant['role']));

                if ($userId <= 0 || $courseId <= 0) {
                    Log::error('Invalid user_id or course_id', [
                        'user_id' => $userId,
                        'course_id' => $courseId,
                    ]);
                    throw new \Exception('Invalid user_id or course_id');
                }

                $courseUserData = [
                    'course_id' => $courseId,
                    'user_id' => $userId,
                    'participant_role' => $participantRole,
                ];
                Log::info('Attempting to create CourseUser entry', ['data' => $courseUserData]);

                try {
                    $courseUser = CourseUser::create($courseUserData);
                    Log::info("Participant added", [
                        'course_user_id' => $courseUser->id,
                        'course_id' => $course->id,
                        'user_id' => $userId,
                        'role' => $participantRole
                    ]);
                } catch (QueryException $e) {
                    Log::error('Failed to create CourseUser entry', [
                        'data' => $courseUserData,
                        'error' => $e->getMessage(),
                        'sql' => $e->getSql(),
                        'bindings' => $e->getBindings()
                    ]);
                    throw new \Exception('Failed to add participant: ' . $e->getMessage());
                }
            }

            DB::commit();
            return redirect()->route('coursesadmin.index')->with('success', 'Course and participants successfully updated');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update course or participants: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Failed to update course or participants: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Cari kursus berdasarkan ID
            $course = MDLCourse::findOrFail($id);
            Log::info('Attempting to delete course', ['course_id' => $id]);

            // Hapus gambar kursus dari storage jika ada
            if ($course->course_image) {
                Storage::disk('public')->delete($course->course_image);
                Log::info('Course image deleted', ['course_id' => $id, 'image_path' => $course->course_image]);
            }

            // Hapus relasi di tabel course_user
            $courseUserDeleted = CourseUser::where('course_id', $id)->delete();
            Log::info('CourseUser entries deleted', ['course_id' => $id, 'rows_deleted' => $courseUserDeleted]);

            // Hapus sections yang terkait
            $sectionsDeleted = MDLSection::where('course_id', $id)->delete();
            Log::info('Sections deleted', ['course_id' => $id, 'rows_deleted' => $sectionsDeleted]);

            // Hapus kursus
            $course->delete();
            Log::info('Course deleted successfully', ['course_id' => $id]);

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete course: ' . $e->getMessage(), [
                'course_id' => $id,
                'exception' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete course: ' . $e->getMessage()
            ], 500);
        }
    }




    public function management(Request $request)
    {
        // Ambil parameter pencarian dan paginasi
        $searchValue = $request->input('search', '');
        $perPage = $request->input('per_page', 10);

        // Query utama untuk kursus
        $query = MDLCourse::select('mdl_course.*')
            ->with(['users' => function ($query) {
                $query->where('course_user.participant_role', 'Teacher')
                    ->select('users.id', 'users.name');
            }]);

        // Pencarian
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('short_name', 'like', "%{$searchValue}%")
                    ->orWhere('full_name', 'like', "%{$searchValue}%")
                    ->orWhere('semester', 'like', "%{$searchValue}%");
            });
        }

        // Paginasi
        $courses = $query->paginate($perPage);


        // Pastikan $courses adalah LengthAwarePaginator
        if (!($courses instanceof \Illuminate\Pagination\LengthAwarePaginator)) {
            Log::error('Courses is not a LengthAwarePaginator', ['courses' => $courses]);
            throw new \Exception('Failed to paginate courses');
        }

        // Format data untuk view
        $data = [
            'courses' => $courses,
            'menu' => 'menu.v_menu_admin',
            'content' => 'Admin.Course.courses_management' // Sesuaikan dengan nama file view
        ];

        return view('layouts.v_template', $data);
    }

}
