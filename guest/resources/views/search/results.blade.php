@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Kết quả tìm kiếm cho "{{ $query }}"</h2>

        @if($products->isEmpty())
            <p>Không tìm thấy sản phẩm nào phù hợp.</p>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-4">
                        <div class="product">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ $product->feature_image_path }}" alt="{{ $product->name }}">
                                <h3>{{ $product->name }}</h3>
                                <p>{{ $product->price }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
