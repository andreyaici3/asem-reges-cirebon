<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'changePassword', 'storePassword');
    }

    public function login()
    {
        return view("auth.login");
    }

    public function storeLogin(LoginRequest $request){
        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password,
        ])){
            return redirect()->to(route("dashboard"));
        }else {
            return redirect()->to(route("auth.login"))->with("gagal", "Periksa Kembali Username / Password Anda");
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to(route("auth.login"))->with("sukses", "Logout Berhasil");
    }    

    public function changePassword()
    {
        return view('all.password.change');
    }

    public function storePassword(ChangePasswordRequest $request)
    {
        User::find(Auth::user()->id)->update([
            "password" => Hash::make($request->password)
        ]);
        return redirect()->to(route("auth.change"))->with("sukses", "Password Berhasil Diubah");
    }
}
