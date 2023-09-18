<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        return view('auth.login', $data);
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Login berhasil
            session(['current_role' => Auth::user()->default_role]);
            // dd(session('current_role'));
            return redirect()->intended(route('dashboard.index')); // Ganti dengan halaman setelah login berhasil
        } else {
            // Login gagal
            session()->flash('warning', 'Email or password not matches');
            return back();
        }
    }

    public function register()
    {
        $data = [
            'title' => 'Register'
        ];
        return view('auth.register', $data);
    }

    function doRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|'. Rule::unique('users', 'username'),
            'email' => 'required|string|max:255|'. Rule::unique('users', 'email'),
            'phone' => 'required|string|max:15|'. Rule::unique('users', 'phone'),
            'password' => 'required|string|min:8|confirmed'
        ]);
        // dd($validator->fails());
        if ($validator->fails()) {
            return redirect(route('register'))
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        // dd($user);
        Auth::attempt(['email' => $user->email, 'password' => $request->password]);
        session()->flash('success', 'Register Successfully');
        return redirect()->intended(route('cms.dashboard')); // Ganti dengan halaman setelah login berhasil



    }

    public function logout()
    {
        Auth::logout();

        session()->flash('success', 'You has logout');
        return redirect()->intended('login');
    }
}
