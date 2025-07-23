<?php

namespace App\Http\Controllers;

use App\Models\MDLCourse;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    /**
     * Menampilkan daftar peserta untuk mata kuliah tertentu.
     *
     * @param int $courseId
     * @return \Illuminate\View\View
     */
    public function index($courseId)
    {
        $course = MDLCourse::with('users')->findOrFail($courseId);

        $participants = $course->users->map(function ($user) {
            return [
                'id' => $user->pivot->id,
                'user_id' => $user->id, // Opsional, untuk keperluan lain
                'name' => $user->name,
                'participant_role' => $user->pivot->participant_role,
                'course_id' => $user->pivot->course_id,
            ];
        });

        $modalId = 'participantModal_' . $courseId;

        return view('admin.course.participant', compact('course', 'participants', 'modalId'));
    }

    /**
     * Menampilkan form untuk menambah peserta baru ke mata kuliah.
     *
     * @param int $courseId
     * @return \Illuminate\View\View
     */
    public function create($courseId)
    {
        $course = MDLCourse::findOrFail($courseId);
        $availableUsers = User::whereDoesntHave('courses', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->get();
        return view('admin.course.participant_create', compact('course', 'availableUsers'));
    }

    /**
     * Menyimpan peserta baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'participants' => 'required|array|min:1',
            'participants.*.id' => 'required|exists:users,id',
            'participants.*.role' => 'required|in:Student,Teacher,Admin',
        ]);

        try {
            $course = MDLCourse::findOrFail($courseId);
            $syncData = [];
            foreach ($request->input('participants') as $participant) {
                $syncData[$participant['id']] = ['participant_role' => $participant['role']];
            }

            $existingParticipants = $course->users()->whereIn('users.id', array_keys($syncData))->pluck('users.id')->toArray();
            $newParticipants = array_diff(array_keys($syncData), $existingParticipants);
            $course->users()->syncWithoutDetaching($syncData);



            return response()->json([
                'success' => true,
                'message' => count($newParticipants) . ' participants added, ' . (count($syncData) - count($newParticipants)) . ' updated successfully',
                'data' => [
                    'new_participants' => $newParticipants,
                    'updated_participants' => array_intersect(array_keys($syncData), $existingParticipants)
                ]
            ]);
        } catch (\Exception $e) {


            return response()->json([
                'success' => false,
                'message' => 'Failed to add participants: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeParticipant(Request $request, $courseId)
    {
        $request->validate([
            'participants' => 'required|array|min:1',
            'participants.*.id' => 'required|exists:users,id',
            'participants.*.role' => 'required|in:Student,Teacher,Admin',
        ]);

        try {
            $course = MDLCourse::findOrFail($courseId);
            $participants = $request->input('participants');

            foreach ($participants as $participant) {
                $course->users()->syncWithoutDetaching([
                    $participant['id'] => ['participant_role' => $participant['role']]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Participants added successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add participants: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Memperbarui peran peserta untuk mata kuliah tertentu.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $participant = CourseUser::findOrFail($id);

        $validated = $request->validate([
            'participant_role' => ['required', Rule::in(CourseUser::PARTICIPANT_ROLES)],
        ]);

        $participant->update($validated);

        return redirect()->route('coursesadmin.index')
            ->with('success', 'Peran peserta berhasil diperbarui')
            ->with('openModal', true); // Flag untuk membuka modal
    }

    /**
     * Menghapus peserta dari mata kuliah.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $participant = CourseUser::findOrFail($id);
        $courseId = $participant->course_id;
        $participant->delete();

        return redirect()->route('coursesadmin.index')
            ->with('success', 'Peserta berhasil dihapus');
    }
}
