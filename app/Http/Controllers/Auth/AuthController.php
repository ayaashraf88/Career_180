<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginUser;
use App\Actions\Auth\LogoutUser;
use App\Actions\Auth\RegisterUser;
use App\DTOs\Auth\LoginData;
use App\DTOs\Auth\RegiserData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $loginUser;
    protected $logoutUser;
    protected $registerUser;
    public function __construct(LoginUser $loginUser, LogoutUser $logoutUser, RegisterUser $registerUser)
    {
        $this->loginUser = $loginUser;
        $this->logoutUser = $logoutUser;
        $this->registerUser = $registerUser;
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $loginData = LoginData::fromRequest($request);
            $user = $this->loginUser->execute($loginData);
            return redirect()->intended('/');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }
    public function logout(Request $request)
    {
        try {
            $this->logoutUser->handle($request);
            return redirect('/');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors(['error' => $e->errors()])->withInput();
        }
    }
    function showRegisterForm()
    {
        return view('auth.register');
    }
    function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $regitserData = RegiserData::fromRequest($request);
            $user = $this->registerUser->execute($regitserData);
            if ($user) {
                return redirect()->intended('/');
            } else {
                return back()->withErrors(['email' => 'Registration failed'])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }
}
