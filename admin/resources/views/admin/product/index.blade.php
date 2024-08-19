@extends('layouts.admin')

@section('title')
  <title>List product</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
<link href="{{ asset('admins/product/index/list.css') }}" rel="stylesheet" />
@endsection

@section('js')
 <script src="{{ asset('vendor/sweetAlert2/sweetalert2@11.js') }}"></script>
 <script src="{{ asset('admins/product/index/list.js') }}"></script>
@endsection

@section('content')

<div class="content-wrapper">
@include('partials.content-header',['name'=> 'product', 'key'=> 'List'])
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Tìm kiếm và lọc form -->
        <div class="col-md-12 mb-3">
          <form method="GET" action="{{ route('products.index') }}" class="row g-3">
            <div class="col-md-3">
              <input type="text" class="form-control" name="query" placeholder="Search products" value="{{ request()->input('query') }}">
            </div>
            <div class="col-md-3">
              <select class="form-select" name="category_id">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ request()->input('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-select" name="sort_by">
                <option value="">Sort By</option>
                <option value="views_asc" {{ request()->input('sort_by') == 'views_asc' ? 'selected' : '' }}>Views Ascending</option>
                <option value="views_desc" {{ request()->input('sort_by') == 'views_desc' ? 'selected' : '' }}>Views Descending</option>
                <option value="price_asc" {{ request()->input('sort_by') == 'price_asc' ? 'selected' : '' }}>Price Ascending</option>
                <option value="price_desc" {{ request()->input('sort_by') == 'price_desc' ? 'selected' : '' }}>Price Descending</option>
              </select>
            </div>
            <div class="col-md-12 mt-3">
              <button class="btn btn-primary" type="submit">Search</button>
              <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
            </div>
          </form>
        </div>

        <div class="col-md-12">
          <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-success">Add</a>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Danh mục</th>
                <th scope="col">Số lượt xem</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr>
                <th scope="row">{{ $product->id }}</th>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price) }}</td>
                <td>
                  <img src="{{ $product->feature_image_path }}" class="product_image_150_100">
                </td>
                <td>{{ optional($product->category)->name }}</td>
                <td>{{ $product->views_count }}</td>
                <td>
                  <a href="{{ route('products.edit', ['id'=> $product->id]) }}" class="btn btn-default">Edit</a>
                  <a href="{{ route('products.delete', ['id'=> $product->id]) }}" data-url="{{ route('products.delete', ['id'=> $product->id]) }}" class="btn btn-danger action_delete">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
