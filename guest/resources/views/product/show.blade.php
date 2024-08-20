@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->feature_image_path }}" alt="{{ $product->name }}" class="img-responsive">
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p>Giới thiệu: {{ strip_tags($product->content) }}</p>
                <p>Price: {{ $product->price }}</p>
                <p>Lượt xem: {{ $product->views_count }}</p>
                <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
@endsection
