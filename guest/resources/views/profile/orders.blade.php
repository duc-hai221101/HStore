@extends('layouts.master')

@section('content')
<div class="container">
    <h1>My Orders</h1>

    @if ($orders->isEmpty())
        <p>You have no orders.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->total_amount }} VND</td>
                        <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">View Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
