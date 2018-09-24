<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\ResponseFactory;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    protected $response;

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
    protected $redirectTo = '/shopping';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ResponseFactory $response)
    {
        $this->middleware('guest')->except('logout');
        $this->response = $response;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $role = $this->guard()->user()->role->role;

        if($role == 'admin'){
            return $this->response->redirectToRoute('admin.index');
        }else if($role == 'customer'){
            return $this->response->redirectToRoute('shopping.index');
        }else{
            return $this->response->redirectToRoute('visitor.login');
        }
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}
