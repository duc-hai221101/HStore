<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;

class CartController extends Controller
{
    public function getCartCount()
    {
        $user = Auth::user();
        if ($user && $user->cart) {
            $cartCount = $user->cart->items->sum('quantity');
        } else {
            $cartCount = 0;
        }
    
        return response()->json(['cart_count' => $cartCount]);
    }
        public function updateQuantity(Request $request, $itemId)
    {
        $quantity = $request->input('quantity');
        $cartItem = CartItem::find($itemId);

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function showCart()
    {if (!Auth::check()) {
        return redirect()->route('login')->with('message', 'Please login to view your cart.');
    }
    else{
        $user = Auth::user();
    if (!$user->cart) {
        $cart = new Cart();
    } else {
        $cart = $user->cart;
    }

    $totalPrice = $cart->items->sum(function($item) {
        return $item->price * $item->quantity;
    });
        $sliders = Slider::latest()->get();
        $categories = Category::where('parent_id',0)->get();
        $products = Product::latest()->take(6)->get();
        $recommendView = Product::orderBy('views_count', 'desc')->take(12)->get();
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();
        
        $totalPrice = $cart ? $cart->total_price : 0;
    
        return view('cart.show', compact('cart', 'sliders', 'categories', 'products', 'recommendView', 'categoriesLimit', 'totalPrice'));
    }
}

public function addToCart(Request $request, $productId)
{
    $user = Auth::user();
    if (!$user->cart) {
        $cart = Cart::create(['user_id' => $user->id]);
    } else {
        $cart = $user->cart;
    }

    $product = Product::find($productId);
    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found']);
    }

    $cartItem = $cart->items()->where('product_id', $productId)->first();
    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->price = $product->price; // Cập nhật giá sản phẩm
        $cartItem->save();
    } else {
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => 1,
            'price' => $product->price // Thêm giá sản phẩm
        ]);
    }

    $cartCount = $cart->items->sum('quantity');

    return response()->json([
        'success' => true,
        'cart_count' => $cartCount
    ]);
    
}

public function update(Request $request, $itemId)
{
    $item = CartItem::findOrFail($itemId);
    $item->quantity = $request->input('quantity');
    $item->save();

    return response()->json(['success' => true]);
}
    public function removeFromCart($itemId)
    {
        $cartItem = CartItem::find($itemId);
        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.show');
    }
}