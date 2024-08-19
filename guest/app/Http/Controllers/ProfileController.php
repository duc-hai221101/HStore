<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Hash;
use App\Models\Category;
use App\Models\Product;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // 
    public function show()
    {
        $categoriesLimit = Category::where('parent_id', 0)->take(3)->get();
        $products = Product::paginate(3); // Hoặc thay đổi truy vấn nếu cần
        $categories = Category::where('parent_id', 0)->get();

        return view('profile.show', compact('categoriesLimit', 'products', 'categories'));
    }

    public function edit()
    {
        $user = Auth::user();
        $categoriesLimit = Category::where('parent_id', 0)->take(3)->get();
        $products = Product::paginate(3); // Hoặc thay đổi truy vấn nếu cần
        $categories = Category::where('parent_id', 0)->get();
        return view('profile.edit', compact('categoriesLimit', 'products', 'categories','user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully.');
    }
}
