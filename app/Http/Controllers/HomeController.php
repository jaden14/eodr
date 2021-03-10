<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index( Request $Request)
    {
        return view('welcome',[]);
    }

    public function verify(Request $request)
    {
        if(Auth::attempt([
            'cats' => $request->cats,
            'password' => $request->password,

        ]) && Auth::user()->user_type =='Supervisor') {
            $request->session()->regenerate();

            return redirect()->intended( url('/accomplishment'));
        } else {
            Auth::logout();
                   return redirect('/supervisor_login')->with('delete', 'Your account is not Supervisor');
        }
    }
    
}
