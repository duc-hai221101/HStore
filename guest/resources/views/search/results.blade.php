@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Search Results</h1>

        @if($results['hits']['total']['value'] > 0)
            <div class="row">
                @foreach($results['hits']['hits'] as $hit)
                    <div class="col-md-4">
                        <div class="product">
                            <div class="product-image">
                                <img src="{{ $hit['_source']['feature_image_path'] }}" alt="{{ $hit['_source']['name'] }}" class="img-responsive">
                            </div>
                            <div class="product-details">
                                <h2>{{ $hit['_source']['name'] }}</h2>
                                <p>{{ $hit['_source']['content'] }}</p>
                                <p><strong>Price: </strong>{{ $hit['_source']['price'] }}</p>
                                <a href="{{ route('product.show', $hit['_source']['id']) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No results found for "{{ request('query') }}"</p>
        @endif
    </div>
@endsection
