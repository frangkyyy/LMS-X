<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use App\Models\MDLCourse;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = CourseUser::with('course')->get();
        return view('admin.course.participant', compact('participants'));
    }

    public function create()
    {
        // return view('participants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'participant_role' => 'nullable|string|max:255',
        ]);

        CourseUser::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'participant_role' => $request->participant_role,
        ]);

        return redirect()->back()->with('success', 'Participant added successfully.');
    }

    public function show(CourseUser $participant)
    {
        // $participant->load('course');
        // return view('participants.show', compact('participant'));
    }

    public function edit(CourseUser $participant)
    {
        // return view('participants.edit', compact('participant'));
    }

    // public function update(Request $request, CourseUser $participant)
    // {
    //     $request->validate([
    //         'course_id' => 'required|exists:courses,id',
    //         'user_id' => 'required|exists:users,id',
    //         'participant_role' => 'nullable|string|max:255',
    //     ]);

    //     $participant->update([
    //         'course_id' => $request->course_id,
    //         'user_id' => $request->user_id,
    //         'participant_role' => $request->participant_role,
    //     ]);

    //     return redirect()->route('participants.index')->with('success', 'Participant updated successfully.');
    // }


        public function getParticipantsByCourse($courseId)
        {
            // Ambil course beserta users yang terkait
            $course = MDLCourse::with(['users' => function ($query) {
                $query->select('users.id', 'users.name'); // Ambil hanya id dan nama user
            }])->findOrFail($courseId);

            // Format data untuk response
            $participants = $course->users->map(function ($user) use ($courseId) {
                return [
                    'course_id' => $courseId,
                    'user_id' => $user->id,
                    'name' => $user->name, // Nama user
                    'participant_role' => $user->pivot->participant_role, // Ambil dari tabel pivot
                ];
            });

            return response()->json($participants);
    }

    // public function destroy(CourseUser $participant)
    // {
    //     $participant->delete();
    //     return redirect()->route('participants.index')->with('success', 'Participant deleted successfully.');
    // }
}
