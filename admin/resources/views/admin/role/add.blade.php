@extends('layouts.admin')

@section('title')
  <title>Trang Chủ</title>
@endsection

@section('css')
<link href="{{ asset('admins/role/add/add.css') }}" rel="stylesheet" />

@endsection
@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('admins/role/add/add.js') }}"></script>
@endsection

@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'slider', 'key' => 'Add'])

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data" style="width: 100%">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tên vai trò</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên slider" value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Mô tả vai trò</label>
                            <textarea class="form-control @error('display_name') is-invalid @enderror" name="display_name" cols="30" rows="10">{{ old('display_name') }}</textarea>
                            @error('display_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">
                                    <input type="checkbox" class="check_all" name="check_all" id="check_all">All
                                </label>
                            </div>
                            @foreach ($permissions as $permission)
                                <div class="card border-primary mb-3 col-md-12">
                                    <div class="card-header">
                                        <label>
                                            <input class="checkbox_wrapper" type="checkbox" value="">
                                        </label>
                                        Module {{ $permission->name }}
                                    </div>
                                    <div class="row">
                                        @foreach ($permission->rolePer as $permissionChild)
                                            <div class="card-body text-primary col-md-3">
                                                <h5 class="card-title">
                                                    <label>
                                                        <input class="checkbox_child" type="checkbox" name="permission_id[]" value="{{ $permissionChild->id }}">
                                                    </label>
                                                    {{ $permissionChild->name }}
                                                </h5>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
</div>
@endsection
