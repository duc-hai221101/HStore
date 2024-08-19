@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection

@section('content')
<script>
    @if(session('success'))
        alert("{{ session('success') }}");
        {{ session()->forget('success') }};
    @endif
</script>
<div class="content-wrapper">
  @include('partials.content-header',['name'=>'slider','key'=> 'Edit'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('sliders.update', ['id' => $slider->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label>Tên slider</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên slider" value="{{ old('name', $slider->name) }}">
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>Mô tả slider</label>
              <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="30" rows="10">{{ old('description', $slider->description) }}</textarea>
              @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="image_path">Hình ảnh</label>
              <input type="file" class="form-control-file" id="image_path" name="image_path">
              @if ($slider->image_path)
                <img src="{{ $slider->image_path }}" alt="Slider Image" width="200">
              @endif
            </div>
          
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
