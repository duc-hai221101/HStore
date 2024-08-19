
@extends('layouts.admin')
 
@section('title')
  <title>Add product</title>
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
 @include('partials.content-header',['name'=>'product','key'=> 'Add'])
 {{-- <div class="col-md-12">
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif --}}
 <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
            @csrf
            <div class="form-group">
              <label>Tên sản phẩm</label>
              <input type="text"  name="name"class="form-control @error('name') is-invalid @enderror" 
              value="{{ old('name') }}"
              placeholder="Nhập tên sản phẩm">
              @error('name')
                 <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Giá sản phẩm</label>
              <input type="text" name="price"class="form-control @error('price') is-invalid @enderror" 
              value="{{ old('price') }}"

              placeholder="Nhập giá sản phẩm">
              @error('price')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="form-group">
              <label>Ảnh đại diện</label>
              <input type="file" multiple name="feature_image_path"
                     class="form-control-file">
            </div>

            <div class="form-group-file">
              <label>Ảnh chi tiết</label>
              <input type="file"
              multiple
              name="image_path[]"class="form-control-file">
            </div>
            
            

            <div class="form-group">
              <label>Chọn danh mục</label>
              <select class="form-control select2_init @error('category_id') is-invalid @enderror " name="category_id" >
                <option value="">Chọn danh mục</option>
                {!! $htmlOption !!}
              </select>
              @error('category_id')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="form-group">
              <label>Nhập tag sản phẩm</label>
              <select class="form-control tag_select_choose  @error('tags') is-invalid @enderror " 
              name="tags[]" multiple="multiple">
              </select>
              @error('tags')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
         
      </div>
      <div class="col-md-12">
        <div class="form-group">
            <label>Nhập nội dung</label>
            <textarea name="contents"class="form-control summernote  @error('contents') is-invalid @enderror " id="summernote" rows="10 "> 
              {{ old('contents') }}
            </textarea>
            @error('contents')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
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