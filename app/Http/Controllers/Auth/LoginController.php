<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function login_data(Request $req)
    {
        $validated = $req->validate([
            'user_name' => 'required',
            'password' => 'required'
        ]);
        if ($validated) {
            if (Auth::attempt(['email' => $req->user_name, 'password' => $req->password])) {
                return redirect('/category');
            } else {
                return back()->with('fail', 'Wrong credential');
            }
        }
    }

    public function logout(Request $req)
    {
        Session::flush();
        Auth::logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect('login');
    }
}
