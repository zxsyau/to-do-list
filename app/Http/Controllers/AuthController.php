<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function postLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        };

        $auth = Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if($auth){
            return redirect()->route('dashboard')->with(['message' => 'Selamat Datang!']);
        };

        return redirect()->back()->withErrors(['errors' => 'Invalid credential']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
