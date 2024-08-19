
@extends('layouts.admin')
 
@section('title')
  <title>Edit product</title>
@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<script src="https://cdn.tiny.cloud/1/uakxseqw0upmplcb3ophyk3j7l0ptrt67ovwm9ngjpqlb9wl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<link href="{{ asset('admins/product/add/add.css') }}" rel="stylesheet" />

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

<script src="{{ asset('admins/product/add/add.js') }}"></script>

@endsection

@section('content')

<div class="content-wrapper">
 @include('partials.content-header',['name'=>'product','key'=> 'Edit'])
 <form action="{{ route('products.update',['id'=> $product->id]) }}" method="POST" enctype="multipart/form-data">

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
            @csrf
            <div class="form-group">
              <label>Tên sản phẩm</label>
              <input type="text" value="{{ $product->name }}" name="name"class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="form-group">
              <label>Giá sản phẩm</label>
              <input type="text" 
              value="{{ $product->price }}"
              name="price"class="form-control" placeholder="Nhập giá sản phẩm">
            </div>
            
            <div class="form-group">
              <label>Ảnh đại diện</label>
              <div class="col-md-12">
                <div class="row">
                  <img width="150px" height="150px" src="{{ $product->feature_image_path }}" alt="">
                </div>
              </div>
              <input type="file" multiple name="feature_image_path"
            </div>

            <div class="form-group contact">
              <label>Ảnh chi tiết</label>
              <input type="file"
              multiple
              name="image_path[]"class="form-control-file" margin-bottom="20px">
              
              <div class="col-md-12 contact" >
                <div class="row">
                  @foreach ($product->images as $productImageItem)   
                    <div class="col-md-3">
                      <img width="100%" height="150px" src="{{ $productImageItem->image_path }}" alt="">
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            
            

            <div class="form-group">
              <label>Chọn danh mục</label>
              <select class="form-control select2_init" name="category_id" >
                <option value="">Chọn danh mục</option>
                {!! $htmlOption !!}
              </select>
            </div>
            
            <div class="form-group">
              <label>Nhập tag sản phẩm</label>
              <select class="form-control tag_select_choose" name="tags[]" multiple="multiple">
                @foreach ($product->totags as $tag)
                <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
            @endforeach
              </select>
            </div>
          </div>
         
      </div>
      <div class="col-md-12">
        <div class="form-group">
            <label>Nhập nội dung</label>
            <textarea

            name="contents"class="form-control summernote" id="summernote" rows="10 ">            {{ $product->content }}
          </textarea>
        </div>
      </div>
        <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</form>

</div>
@endsection