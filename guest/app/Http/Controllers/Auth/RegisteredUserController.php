<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Mail;
use App\Mail\VerificationEmail;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'phone' => ['required', 'string', 'max:15'], // Thêm dòng này để validate phone
        ]);
        $data=$request->only('name','email','password',);
        $data['password']= Hash::make($request->password);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone'=>$request->phone,
        //     'password' => Hash::make($request->password),
        // ]);

        if($user=User::create($data)){
            Mail::to($user->email)->send(new VerificationEmail($user));
            return redirect()->route('login')->with('Ok','Đăng ký thành công, check mail xác nhận.');
        }
    
        return redirect()->back()->with('No', 'lỗi rồi!');
    }
    public function verify($email){

        $user = User::where('email', $email)->whereNull('email_verified_at')->first();
        User::where('email', $email)->update(['email_verified_at'=>now()]);
        
        return redirect()->route('login')->with('Ok','Xác nhận thành công');
    }
    
}