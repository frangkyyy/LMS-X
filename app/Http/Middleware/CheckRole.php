<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,... $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $allowedRoles = array_map('intval',  $roles);

        // Log for debugging (optional, remove in production if not needed)
        Log::debug('CheckRole Middleware', [
            'roles' => $roles,
            'allowedRoles' => $allowedRoles,
            'user_id_role' => $user->id_role
        ]);

        if (!in_array($user->id_role, $allowedRoles)) {
            // Redirect to a route not protected by ensure.ils or role:2,1
            return redirect()->route('home')->with('error', 'Kamu tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}
