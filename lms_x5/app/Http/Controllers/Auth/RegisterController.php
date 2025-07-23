<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = User::where('email', $value)
                        ->where('status', 'active') //cek yang statusnya 'active'
                        ->exists();

                    if ($exists) {
                        $fail('The email has already been taken.');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'level' => ['string'],
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
            'name' => $data['name'],
            'email' => $data['email'],
            'level' => '1',
            'status' => 'pending',
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
{
    $this->validator($request->all())->validate();

    // Simpan pengguna tetapi dengan status menunggu konfirmasi admin
    $user = $this->create($request->all());

    // Set session khusus setelah register
     session(['just_registered' => true]);

    // Redirect dengan pesan sukses
    return redirect()->route('register.success');
}

}
