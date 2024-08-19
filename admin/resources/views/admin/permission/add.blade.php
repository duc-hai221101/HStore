
@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection
@section('css')
<link href="{{ asset('admins/role/add/add.css') }}" rel="stylesheet" />

@endsection
@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('admins/permission/add/add.js') }}"></script>
@endsection
@section('content')

<div class="content-wrapper">
 @include('partials.content-header',['name'=>'permission','key'=> 'Add'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form action="{{ route('permissions.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Chọn module</label>
                <select class="form-control" name="module_parent" >
                  <option value="">Chọn module</option>
                 @foreach (config('permissions.table_module') as $item)
                 <option value="{{ $item }}">{{ $item }}</option>
                 @endforeach


                </select>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">
                        <input type="checkbox" class="check_all" name="check_all" id="check_all">All
                    </label>
                </div>
                  @foreach (config('permissions.table_child') as $item)

                    <div class="col-md-3">
                        <label for="">
                            <input type="checkbox" class ="module_child" name="module_child[]" value="{{ $item }}"> {{ $item }}
                        </label>
                    </div>
                   @endforeach
                </div>
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