!function( $ ) {
    document.addEventListener('DOMContentLoaded', function() {
        function updateCartCount() {
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#cart-count').textContent = data.cart_count;
                })
                .catch(error => console.error('Error fetching cart count:', error));
        }
    
        function updateCartTotal() {
            let totalPrice = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                const quantity = parseInt(input.value);
                const price = parseFloat(input.closest('tr').querySelector('td:nth-child(3)').textContent.replace('$', '').replace(',', ''));
                const totalCell = input.closest('tr').querySelector('.total-price');
                const total = quantity * price;
                totalCell.textContent = `$${total.toFixed(2)}`;
                totalPrice += total;
            });
            document.querySelector('#cart-total').textContent = `$${totalPrice.toFixed(2)}`;
        }
    
        updateCartCount(); // Cập nhật số lượng khi trang được tải
    
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
    
                const productId = this.dataset.productId;
    
                fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId })
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
    
        // Xử lý thay đổi số lượng sản phẩm trong giỏ hàng
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.itemId;
                const quantity = this.value;
    
                fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartTotal(); // Cập nhật tổng tiền sau khi thay đổi số lượng
                        updateCartCount(); // Cập nhật số lượng giỏ hàng sau khi thay đổi
                    } else {
                        alert('Error updating quantity');
                    }
                })
                .catch(error => console.error('Error updating quantity:', error));
            });
        });
    });
}