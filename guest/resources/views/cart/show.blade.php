<!-- resources/views/cart.blade.php -->
@extends('layouts.master')

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currencyFormatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            function updateCartCount() {
                fetch('{{ route('cart.count') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#cart-count').textContent = data.cart_count;
                    })
                    .catch(error => console.error('Error fetching cart count:', error));
            }

            // Cập nhật số lượng giỏ hàng khi trang tải
            updateCartCount();
            updateCartTotal();

            function updateCartTotal() {
                let totalPrice = 0;
                document.querySelectorAll('.quantity-input').forEach(input => {
                    const quantity = parseInt(input.value, 10);
                    const priceText = input.closest('tr').querySelector('td:nth-child(3)').textContent;
                    const price = parseFloat(priceText.replace(' VND', '').replace(/,/g, ''));
                    const totalCell = input.closest('tr').querySelector('.total-price');
                    const total = quantity * price;
                    totalCell.textContent = currencyFormatter.format(total);
                    totalPrice += total;
                });
                document.querySelector('#cart-total').textContent = currencyFormatter.format(totalPrice);
            }
            updateCartTotal();

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const itemId = input.dataset.itemId;
                    const newQuantity = parseInt(input.value, 10);

                    // AJAX request để cập nhật số lượng trong cơ sở dữ liệu
                    fetch(`/cart/update/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartTotal(); // Cập nhật tổng tiền sau khi lưu thành công
                        } else {
                            alert('Failed to update quantity.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            updateCartTotal();
        });
    </script>
@endsection

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    @if ($cart && $cart->items->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            <input type="number" 
                                   min="1" 
                                   value="{{ $item->quantity }}" 
                                   data-item-id="{{ $item->id }}" 
                                   class="quantity-input" />
                        </td>
                        <td class="text">{{ number_format($item->price) }} VND</td>
                        <td class="text total-price">{{ number_format($item->price * $item->quantity) }} VND</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td class="text" id="cart-total">{{ number_format($totalPrice) }} VND</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <!-- Thêm nút Đặt hàng -->
        <div class="text-right">
            <a href="{{ route('order.create') }}" class="btn btn-primary">Place Order</a>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
