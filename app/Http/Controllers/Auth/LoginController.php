<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'login' => 'required|regex:/[0-9]{3}/|digits:3',
        ]);

        // Get user record
        if($user = User::where('login', $request->get('login'))->first()) {

            // Set Auth Details
            Auth::login($user);

            if($user->hasRole('admin')){
                return redirect()->route('admin.users.index');
            }
            elseif ($user->hasRole('technolog') || $user->hasRole('pracownik produkcji')){
                return redirect()->route('ewidencja.praca.create');
            }
            return redirect()->route('/');

        } else {
            $request->session()->flash('danger', 'Podany login nie istnieje w systemie!');
            return redirect()->route('login');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Response|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        if (Auth::user()->hasWorkStarted(Auth::id())) {
            $request->session()->flash('danger', 'Najpierw zakończ rozpoczętą pracę!');
            return redirect()->route('ewidencja.praca.create');
        } else {
            $this->guard()->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if ($response = $this->loggedOut($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new Response('', 204)
                : redirect('/');
        }
    }
}
