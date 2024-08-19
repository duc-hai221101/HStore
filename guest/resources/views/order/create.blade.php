@extends('layouts.master')

@section('js')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật số lượng giỏ hàng
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
    
    // Xử lý sự kiện click vào nút "Add to Cart"
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form

            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(); // Cập nhật số lượng giỏ hàng sau khi thêm sản phẩm
                } else {
                    alert('Error adding to cart');
                }
            })
            .catch(error => console.error('Error adding to cart:', error));
        });
    });
});
		</script>
@endsection
@section('content')
<div class="container">
    <h1>Place Your Order</h1>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price) }} VND</td>
                        <td>{{ number_format($item->price * $item->quantity) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td>{{ number_format($cart->items->sum(function ($item) {
                        return $item->price * $item->quantity;
                    })) }} VND</td>
                </tr>
            </tfoot>
        </table>
        <button type="submit" class="btn btn-primary">Confirm Order</button>
    </form>
</div>
@endsection
