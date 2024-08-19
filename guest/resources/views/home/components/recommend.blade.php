<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Recommended Items</h2>
    
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($recommendView->chunk(3) as $key => $chunk)
                <div class="item {{ $key == 0 ? 'active' : ''}}">
                    @foreach($chunk as $item)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{ config('app.burl') . $item->feature_image_path }}" alt="" />
                                    <h2>{{ number_format($item->price) }}</h2>
                                    <p>{{ $item->name }}</p>
                                    <form class="add-to-cart-form" action="{{ route('cart.add', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-default add-to-cart" data-product-id="{{ $item->id }}">
                                            <i class="fa fa-shopping-cart"></i> Add to cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>			
    </div>
</div><!--/recommended_items-->
