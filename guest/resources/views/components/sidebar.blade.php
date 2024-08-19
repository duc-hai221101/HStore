<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            @foreach($categories as $item)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        @if($item->showCa->count())
                        <a data-toggle="collapse" data-parent="#accordian" href="#sportswear_{{ $item->id }}">
                            <span class="badge pull-right">
                                @if($item->showCa->count())
                                <i class="fa fa-plus"></i>
                                @endif
                            </span>
                            {{ $item->name }}
                        </a>
                        @else
                        <a href="{{ route('category.product', ['slug' => $item->slug, 'id' => $item->id]) }}">
                            <span class="badge pull-right">
                              
                            </span>
                            {{ $item->name }}
                        </a>
                        @endif
                    </h4>
                </div>

                <div id="sportswear_{{ $item->id }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($item->showCa as $child)

                            <li><a href="{{ route('category.product',['slug'=>$child->slug,'id'=>$child->id]) }}">{{ $child->name }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
          @endforeach
        </div><!--/category-products-->
    
        <div class="brands_products"><!--brands_products-->
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
                    <li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                    <li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
                    <li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
                    <li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
                    <li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
                    <li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                </ul>
            </div>
        </div><!--/brands_products-->
        
        <div class="price-range"><!--price-range-->
            <h2>Price Range</h2>
            <div class="well text-center">
                 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div><!--/price-range-->
        
        <div class="shipping text-center"><!--shipping-->
            <img src="/Eshopper/images/home/shipping.jpg" alt="" />
        </div><!--/shipping-->
    
    </div>
</div>
