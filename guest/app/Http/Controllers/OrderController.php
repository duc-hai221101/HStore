<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use DB;
use Hash;
use App\Models\Category;
use Stripe;
use App\Models\Product;
use Mail;
use App\Mail\OrderConfirmationMail;
class OrderController extends Controller
{
    // public function createOrder()
    // {
    //     $user = Auth::user();
    //     $cart = Cart::where('user_id', $user->id)->first();

    //     if (!$cart) {
    //         return redirect()->route('cart.show')->with('error', 'Giỏ hàng trống.');
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // Create Order
    //         $order = Order::create([
    //             'user_id' => $user->id,
    //             'total_amount' => $cart->total_amount, // Ensure you have this field in your Cart model
    //             'status' => 'pending',
    //         ]);

    //         // Transfer Cart Items to Order Items
    //         $cartItems = CartItem::where('cart_id', $cart->id)->get();
    //         foreach ($cartItems as $cartItem) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $cartItem->product_id,
    //                 'quantity' => $cartItem->quantity,
    //                 'price' => $cartItem->price,
    //             ]);
    //         }

    //         // Clear Cart
    //         CartItem::where('cart_id', $cart->id)->delete();

    //         DB::commit();

    //         return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('cart.show')->with('error', 'Lỗi khi đặt hàng.');
    //     }
    // }
    public function create()
    {
        $user = Auth::user();
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();
        $products = Product::where('category_id',$user->id)->paginate(3);
        $categories = Category::where('parent_id',0)->get();
        $cart = Cart::where('user_id', Auth::id())->firstOrFail();
        return view('order.create', compact('cart','categoriesLimit','products','categories'));
    }

    public function store(Request $request)
    {
       // Xử lý tạo đơn hàng từ giỏ hàng
       $cart = Auth::user()->cart;
       $order = new Order();
     

       $order->user_id = Auth::id();
       $order->total_amount = $cart->items->sum(function ($item) {
           return $item->price * $item->quantity;
       });
       $order->status = 'pending'; // Đơn hàng ở trạng thái chờ thanh toán

       $order->save();

       // Thêm các chi tiết đơn hàng
       foreach ($cart->items as $item) {
           $order->items()->create([
               'product_id' => $item->product_id,
               'quantity' => $item->quantity,
               'price' => $item->price,
           ]);
       }

       // Xóa giỏ hàng sau khi đặt hàng thành công
       Auth::user()->cart->items()->delete();

       // Chuyển hướng đến trang thành công
       return redirect()->route('checkout', ['order' => $order->id]);

    //    return redirect()->route('order.success', ['orderId' => $order->id]);
    }
    public function checkout(Order $order)
    {
        $user = Auth::user();
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();
        $products = Product::where('category_id',$user->id)->paginate(3);
        $categories = Category::where('parent_id',0)->get();
        $cart = Cart::where('user_id', Auth::id())->firstOrFail();
        return view('checkout', compact('order','cart','categoriesLimit','products','categories'));
    }

    public function processPayment(Request $request, Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Order #' . $order->id,
                        ],
                        'unit_amount' => $order->total_amount * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('order.success', ['order' => $order->id]),
            'cancel_url' => route('checkout', ['order' => $order->id]),
        ]);

        return redirect($session->url);
    }
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $user = Auth::user();
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();
        $products = Product::where('category_id',$user->id)->paginate(3);
        $categories = Category::where('parent_id',0)->get();
        return view('order.success', compact('order','categoriesLimit','products','categories'));
    }
    public function userOrders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('items')->get();
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();
        $products = Product::where('category_id',$user->id)->paginate(3);
        $categories = Category::where('parent_id',0)->get();
        return view('profile.orders',  compact('orders','categoriesLimit','products','categories'));
    }
    public function show($orderId)
{
    $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
    $categoriesLimit = Category::where('parent_id', 0)->take(3)->get();
    $products = Product::where('category_id', Auth::id())->paginate(3);
    $categories = Category::where('parent_id', 0)->get();

    return view('order.show', compact('order', 'categoriesLimit', 'products', 'categories'));
}
public function updateStatus($orderId, $status)
{
    $order = Order::findOrFail($orderId);
    $order->status = $status;
    $order->save();
    Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

}
}
