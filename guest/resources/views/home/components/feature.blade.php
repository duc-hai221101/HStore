<div class="features_items">
    <h2 class="title text-center">Features Items</h2>
    @foreach($products as $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img class="img-fluid" src="{{ config('app.burl') . $product->feature_image_path }}" alt="" />
                    <h2>${{ number_format($product->price) }}</h2>
                    <p>{{ $product->name }}</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <button type="submit" class="btn btn-default add-to-cart" data-product-id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart"></i> Add to cart
                        </button>
                    </form>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i> Add to wishlist</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i> Add to compare</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>

