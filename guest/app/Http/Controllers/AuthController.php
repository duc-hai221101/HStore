<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use Hash;
use App\Models\User;
use App\Models\Role;
use Auth;
class AuthController extends Controller
{
    private $user;
    private $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
   

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công
            return redirect()->intended('home');
        }

        // Đăng nhập thất bại
        return redirect()->back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    // Hiển thị form đăng ký

    public function create()
    {
        return view('register');
    }
    // Xử lý đăng ký
    public function store(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ]);

    // Tạo người dùng mới
    $user = $this->user->create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Gửi email xác thực
    $user->sendEmailVerificationNotification();

    // Đăng nhập người dùng mới và chuyển hướng đến trang nhà
    return redirect()->route('home')->with('status', 'Verification link sent to your email!');
}

}
