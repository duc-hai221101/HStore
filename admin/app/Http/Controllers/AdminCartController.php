<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;    
class AdminCartController extends Controller
{
    public function index()
    {
        // Tải tất cả người dùng cùng với giỏ hàng và sản phẩm trong giỏ hàng
        $users = User::with('cart.productCart')->get();
        return view('admin.cart.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('cart.productCart')->find($id);

        if (!$user) {
            abort(404, 'User not found');
        }

        return view('admin.cart.show', compact('user'));
    }
}
