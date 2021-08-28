<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;

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
        $this->middleware('guest:administrator')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('administrator')->attempt($credentials)) {
            // Authentication passed...
            $id_admin = Auth::guard('administrator')->user()->id;
            return redirect()->intended('home');
        }
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::guard('administrator')->logout();
        return redirect()
            ->route('login')
            ->with('status','Admin has been logged out!');
    }
}
