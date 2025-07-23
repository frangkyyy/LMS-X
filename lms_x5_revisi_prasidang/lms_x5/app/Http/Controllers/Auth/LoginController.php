<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/kuesioner-ils';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * The user has been authenticated.
     *
     * This method will be triggered after a user is successfully authenticated.
     * We override it here to add a custom check: if the user status is not "active",
     * then the login is rejected and the user is redirected back with an error.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse|null
     */
    protected function authenticated(Request $request, $user)
    {
        // Cek apakah status user tidak "active"
        if ($user->status !== 'active') {
            auth()->logout(); // logout user yang sudah login
            return redirect()->route('login')->withErrors([
                'email' => 'Akun kamu belum diverifikasi oleh admin.',


            ]);
        }

        switch ($user->id_role) {
            case 1:
                return redirect('/dashboard');
            case 2:
                return redirect('/dashboard2');
            case 3:
                return redirect('/home');
            default:
                return redirect('/'); // fallback kalau role nggak dikenali

    }
}
}
