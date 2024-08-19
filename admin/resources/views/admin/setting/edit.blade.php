
@extends('layouts.admin')
 
@section('title')
  <title>Setting</title>
@endsection
@section('css')
<link href="{{ asset('admins\setting\add\add.css') }}" rel="stylesheet" 
@endsection
@section('content')

<div class="content-wrapper">
 @include('partials.content-header',['name'=>'Setting','key'=> 'edit'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('settings.update',['id'=>$setting->id]) }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Config key</label>
              <input type="text" name="config_key"class="form-control  @error('config_key') is-invalid @enderror" value="{{ $setting->config_key }}"
              placeholder="Nhập Config key">
            </div>
            @error('config_key')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @if(request()->type==='Text')
            <div class="form-group">
              <label>Config value</label>
              <input type="text" name="config_value"class="form-control  @error('config_value') is-invalid @enderror" placeholder="Nhập Config value" value="{{ $setting->config_value }}">
            </div>
            @error('config_value')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @elseif(request()->type==='Textarea')
            <div class="form-group">
              <label>Config value</label>
              <textarea name="config_value"class="form-control  @error('config_value') is-invalid @enderror" rows="5">{{ $setting->config_value }}</textarea>
            </div>
            @error('config_value')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @endif
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