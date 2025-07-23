<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserActivated;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if ($request->ajax() && !$request->user()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return $next($request);
        })->only('search');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $roles = Role::all();
        $content = ($user->id_role == 1) ? 'admin.user.index' : 'content.view_user';

        $data = [
            'roles' => $roles,
            'count_user' => User::count(),
            'menu' => 'menu.v_menu_admin',
            'content' => $content,
            'dashboard' => 'content.view_dashboard',
            'title' => 'Table User'
        ];

        if ($request->ajax()) {
            $q_user = User::with('role')
                ->select('users.*')
                ->where('status', '!=', 0)
                ->orderByDesc('created_at');

            if ($user->id_role == 3) {
                $q_user->where('id_role', 3);
            }

            return DataTables::of($q_user)
                ->addIndexColumn()
                ->addColumn('action', function($row) use ($user) {
                    if ($user->id_role != 1) {
                        return '';
                    }
                    return'<div  data-bs-toggle="tooltip" data-id="'.$row->id. '" data-original-title="View"  class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2 viewUser"><i class="fi-rr-eye"></i></div>' .
                        '<div data-bs-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editUser"><i class="fi-rr-edit"></i></div>'.
                        '<div data-bs-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteUser"><i class="fi-rr-trash"></i></div>';
                })
                ->addColumn('name_role', function($row) {
                    return $row->role ? $row->role->name_role : 'No Role';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.v_template', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'status' => 'required|in:pending,active,non-active',
            'password' => 'required|min:5',
            'id_role' => 'required|exists:roles,id_role',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'id_role' => $request->id_role,
            'password' => Hash::make($request->password),
        ];

        try {
            User::create($userData);
            return response()->json(['success' => 'User berhasil dibuat!']);
        } catch (\Exception $e) {
            Log::error('Error membuat user: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat user: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'id_role' => $user->id_role,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'status' => 'required|in:pending,active,non-active',
            'password' => 'nullable|min:5',
            'id_role' => 'required|exists:roles,id_role',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'id_role' => $request->id_role,
        ];

        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        try {
            $statusChanged = $user->status !== $request->status;
            $user->update($userData);

            if ($statusChanged) {
                return response()->json(['success' => 'status berubah!']);
            }
            return response()->json(['success' => 'User berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('Error memperbarui user: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memperbarui user: ' . $e->getMessage()], 500);
        }
    }






    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->id == 4 && $user->id_role == 1) {
            return response()->json(['error' => 'This admin cannot be deleted'], 403);
        }

        $user->delete();
        return response()->json(['success' => 'User deleted successfully!']);
    }

    public function approveUser($id, $newStatus)
    {
        $user = User::find($id);

        if ($user) {
            // Cek apakah status baru berbeda dengan status saat ini
            if ($user->status !== $newStatus) {
                $user->status = $newStatus;
                $user->save();

                return response()->json(['success' => 'status berhasil di update']);
            }
            return response()->json(['error' => 'Tidak ada perubahan status']);
        }

        return response()->json(['error' => 'Pengguna tidak ditemukan']);
    }
    public function search(Request $request)
    {
        $term = $request->query('term', '');
        Log::info('User search initiated', ['term' => $term]);

        if (empty($term)) {
            Log::warning('Empty search term');
            return response()->json([]);
        }

        $users = User::where('name', 'LIKE', '%' . $term . '%')
            ->select('id', 'name')
            ->take(10)
            ->get();

        Log::info('User search results', ['count' => $users->count(), 'users' => $users->toArray()]);
        return response()->json($users);
    }
}
