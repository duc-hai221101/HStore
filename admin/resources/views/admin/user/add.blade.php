@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admins/user/add/add.css') }}" rel="stylesheet" />

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('admins/user/add/add.js') }}"></script>
@endsection



@section('content')

<div class="content-wrapper">
 @include('partials.content-header',['name'=>'user','key'=> 'Add'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="form-group">
              <label>Tên user</label>
              <input type="text" name="name"class="form-control @error('name') is-invalid @enderror" placeholder="Nhập ten user" value="{{ old('name') }}">
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>email</label>
              <input type="email" name="email"class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email" value="{{ old('email') }}">
              @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password"class="form-control @error('password') is-invalid @enderror" placeholder="Nhập password" value="{{ old('Password') }}">
              @error('password')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>

            <div class="form-group">
              <label>Vai tro</label>
              <select class="form-control select2_init @error('role_id') is-invalid @enderror" multiple name="role_id[]" >
               <option value="">
               </option>
               @foreach ($roles as $role)
                    <option class="role @error('role_id') is-invalid @enderror" value="{{ $role->id }}">{{ $role->name }}</option>
               @endforeach

              </select>
              @error('role_id')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
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