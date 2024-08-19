
@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection

@section('content')

<div class="content-wrapper">
 @include('partials.content-header',['name'=>'menu','key'=> 'Add'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('menus.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label>Tên menu</label>
              <input type="text" name="name"class="form-control" placeholder="Nhập tên menu">
            </div>
            
            <div class="form-group">
                <label>Chọn thư mục cha</label>
                <select class="form-control" name="parent_id" >
                  <option value="0">Chọn menu cha</option>
                  {!! $optionSelect !!}
                </select>
              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
@endsection