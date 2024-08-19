@extends('layouts.admin')

@section('title')
  <title>Chi Tiết Giỏ Hàng</title>
@endsection

@section('content')

<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'cart', 'key' => 'List'])
    
    <div class="container">
        <h1>{{ $user->name }}'s Cart</h1>

        @if ($user->cart && $user->cart->productCart->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->cart->productCart as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->pivot->quantity ?? 1 }}</td>
                                <td>${{ number_format($product->price * ($product->pivot->quantity ?? 1), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                            <td>${{ number_format($user->cart->productCart->sum(fn($product) => $product->price * ($product->pivot->quantity ?? 1)), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <p>No items in cart</p>
        @endif
    </div>
</div>

@endsection
