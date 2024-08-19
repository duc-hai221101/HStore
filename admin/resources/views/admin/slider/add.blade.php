@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection

@section('content')

<div class="content-wrapper">
 @include('partials.content-header',['name'=>'slider','key'=> 'Add'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="form-group">
              <label>Tên slider</label>
              <input type="text" name="name"class="form-control @error('name') is-invalid @enderror" placeholder="Nhập ten slider" value="{{ old('name') }}">
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Mo ta slider</label>
              <textarea class="form-control @error('description') is-invalid @enderror"  name="description" id="" cols="30" rows="10">
                {{ old('description') }}
              </textarea>
              @error('description')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Hinh anh</label>
              <input type="file" multiple name="image_path"
                     class="form-control-file">
            </div>
          
          </div>
          <div class="col-md-12">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
          </form>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
@endsection