<!-- resources/views/order/show.blade.php -->
@extends('layouts.master')

@section('content')
@if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container">
    
    <h1>Order Details</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Date: {{ $order->created_at->format('d/m/Y') }}</p>
    <p>Status: {{ ucfirst($order->status) }}</p>
    <p>Total Amount: {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>

    <h2>Items:</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($order->status == 'pending')
    <form action="{{ route('vnpay', $order->id) }}" method="POST">
        @csrf
        <button type="submit" name="redirect" class="primary-btn checkout-btn" >Thanh toán vnpay</button>
        </form>
    @endif
</div>
@endsection
