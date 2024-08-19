<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function login(){
    if(auth()->check()){
        return redirect()->to('home');
    }
    return view('login');
   }
   public function loginAdmin(Request $request){
    $remeber = $request->has('remeber_me') ? true : false;
    if(auth()->attempt([
        'email'=>$request->email,
        'password'=> $request->password],$remeber)){
            return redirect()->to('home');
        }
       
    
   }
}
