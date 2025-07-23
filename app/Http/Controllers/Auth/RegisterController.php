<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nrp' => ['required', 'numeric', 'unique:users,id', 'digits_between:1,20'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = User::where('email', $value)
                        ->where('status', 'active')
                        ->exists();

                    if ($exists) {
                        $fail('Email sudah digunakan oleh akun aktif.');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ], [
            'nrp.required' => 'NRP/NIP/NIK harus diisi.',
            'nrp.numeric' => 'NRP/NIP/NIK hanya boleh berisi angka.',
            'nrp.unique' => 'NRP/NIP/NIK sudah digunakan.',
            'nrp.digits_between' => 'NRP/NIP/NIK harus antara 1 sampai 20 digit.',
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'id' => $data['nrp'], // Gunakan NRP sebagai id (primary key)
            'name' => $data['name'],
            'email' => $data['email'],
            'id_role' => 3, // Default role (misalnya, user biasa), sesuaikan jika ada logika lain
            'status' => 'pending',
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            // Simpan pengguna dengan status menunggu konfirmasi admin
            $user = $this->create($request->all());

            // Set session khusus setelah register
            session(['just_registered' => true]);

            // Log aktivitas (opsional)
            Log::info('User baru terdaftar dengan NRP: ' . $request->nrp . ', email: ' . $request->email);

            // Redirect dengan pesan sukses
            return redirect()->route('register.success')->with('success', 'Registrasi berhasil! Silakan tunggu konfirmasi admin.');
        } catch (\Exception $e) {
            Log::error('Error saat registrasi: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal melakukan registrasi. Silakan coba lagi.']);
        }
    }
}
