
@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection

@section('content')

<div class="content-wrapper">
@include('partials.content-header',['name'=> 'category', 'key'=> 'List'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        @can('category-add')

        <div class="col-md-12">
          <a href="{{ route('categories.create') }}" class="btn btn-success float-right m-2">Add</a>
        </div>
        @endcan
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên danh mục</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $category)
              <tr>
                <th scope="row">{{ $category->id }}</th>
                <td>{{ $category->name }}</td>
                  <td>
                    @can('category-edit')
                    <a href="{{ route('categories.edit',['id'=> $category->id] )}}" class="btn btn-default">Edit</a>
                    @endcan
                    @can('category-delete')
                    <a  href="{{ route('categories.delete',['id'=> $category->id] )}}" class="btn btn-danger">Delete</a>
                    @endcan
                  </td>
              </tr>
              
              @endforeach
              <tr>
              
              </tr>
            </tbody>
          </table>
        
        </div>
        <div class="col-md-12">
          {{ $categories->links() }}
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection