@extends('layouts.master')

@section('title')
	<title>Home page</title>
@endsection

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="{{ asset('home1/home.css') }}">
@endsection

@section('js')
   <script>
    $(document).ready(function(){
    $('#search').on('keyup', function() {
        var query = $(this).val();

        if(query.length > 2) { // Chỉ tìm kiếm khi nhập trên 2 ký tự
            $.ajax({
                url: "{{ route('products.search') }}",
                type: "GET",
                data: {'query': query},
                success: function(data){
                    $('#search-ajax').fadeIn();
                    $('#search-ajax').html(data);
                }
            });
        } else {
            $('#search-ajax').fadeOut();
        }
    });

    $(document).on('click', 'li', function(){
        $('#search').val($(this).text());
        $('#search-ajax').fadeOut();
    });
});
   </script>
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
   {{-- Slider --}}
	@include('home.components.slider')
	{{-- // --}}
<section>
	<div class="container">
		<div class="row">
			
			@include('components.sidebar')
			
			<div class="col-sm-9 padding-right">
				<!--feature-item-->
				@include('home.components.feature')
				<!--feature-->
				<!--category-tab-->
				@include('home.components.tab')
		<!--/category-tab-->
				<!--recommend-item-->
				@include('home.components.recommend')
				<!--recommend-->
			
				
			</div>
		</div>
	</div>
</section>

@endsection
