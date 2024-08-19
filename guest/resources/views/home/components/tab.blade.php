<div class="category-tab">
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @foreach($categories as $keyItem => $category)
            <li class="{{ $keyItem == 0 ? 'active' : '' }}">
                <a href="#cate_tab_{{ $category->id }}" data-toggle="tab">{{ $category->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="tab-content">
        @foreach($categories as $keyItemTab => $category)
        <div class="tab-pane fade {{ $keyItemTab == 0 ? 'active in' : '' }}" id="cate_tab_{{ $category->id }}">
            @foreach($category->products as $product)
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{ config('app.burl') . $product->feature_image_path }}" alt="" />
                            <h2>${{ number_format($product->price) }}</h2>
                            <p>{{ $product->name }}</p>
                            <form class="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-default add-to-cart" data-product-id="{{ $product->id }}">
                                    <i class="fa fa-shopping-cart"></i> Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @foreach($category->children as $child)
                @foreach($child->products as $product)
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ config('app.burl') . $product->feature_image_path }}" alt="" />
                                <h2>${{ number_format($product->price) }}</h2>
                                <p>{{ $product->name }}</p>
                                <form class="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-default add-to-cart" data-product-id="{{ $product->id }}">
                                        <i class="fa fa-shopping-cart"></i> Add to cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>
        @endforeach
    </div>
</div>
