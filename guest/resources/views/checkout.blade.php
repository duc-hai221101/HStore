@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Checkout</h1>
    <form action="{{ route('vnpay', ['orderId' => $order->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="order_id">Order ID:</label>
            <input type="text" class="form-control" name="order_id" value="{{ $order->id }}" readonly>
        </div>
        <div class="form-group">
            <label for="amount">Total Amount:</label>
            <input type="text" class="form-control" name="amount" value="{{ number_format($order->total_amount, 0, ',', '.') }} VND" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Pay with VNPay</button>
    </form>
</div>
@endsection
