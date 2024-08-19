document.addEventListener('DOMContentLoaded', function() {
    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                document.querySelector('#cart-count').textContent = data.cart_count;
            });
    }

    // Gọi updateCartCount khi trang được tải
    updateCartCount();

    // Thực hiện lại updateCartCount khi sản phẩm được thêm vào giỏ hàng
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
                    updateCartCount(); // Cập nhật số lượng giỏ hàng khi sản phẩm được thêm vào
                } else {
                    alert('Failed to add product to cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
