<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_login;

class LoginController extends Controller
{
    public function cekUser(Request $request){
        $user = M_login::where('username', $request->username)->first();
        // dd($request);
        if($user->id_admin != null){
            if(($request->password == $user->password)){
                \Session::put('user', $user);

                return redirect('/');
            }else{
                \Session::flash('error', 'Username atau Password tidak cocok');

                 return redirect('/login');
            }
        }else{
            \Session::flash('error', 'Username tidak ditemukan');

            return redirect('/login');
        }
    }

    public function logout(){
        \Session::flush();

        return redirect('/');
    }

}
