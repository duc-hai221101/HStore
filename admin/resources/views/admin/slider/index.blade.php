
@extends('layouts.admin')
 
@section('title')
  <title>list Slider</title>
  <script>
    @yield('scripts')
  </script>
@endsection


@section('js')
 <script src="{{ asset('vendor/sweetAlert2/sweetalert2@11.js') }}"></script>
 <script src="{{ asset('admins/slider/index/list.js') }}"></script>
@endsection

@section('content')
<div class="content-wrapper">
@include('partials.content-header',['name'=> 'slider', 'key'=> 'List'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <a href="{{ route('sliders.create') }}" class="btn btn-success float-right m-2">Add</a>
        </div>
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên Slider</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sliders as $slider) 
                <tr>
                    <th scope="row">{{ $slider->id }}</th> 
                    <td>{{ $slider->name }}</td>
                    <td>
                      <img src="{{ $slider->image_path }}" width="150px" height="100px" class="product_image_150_100">
                    </td>
                    <td>{{ $slider->description }}</td>

                    <td>
                        <a href="{{ route('sliders.edit',['id'=>$slider->id]) }}" class="btn btn-default">Edit</a>
                        <a href="" data-url="{{ route('sliders.delete', ['id'=> $slider->id]) }}" class="btn btn-danger action_delete">Delete</a>
                      </td>
                </tr> 
              @endforeach
              <tr>    
            </tbody>
          </table>
        
        </div>
        <div class="col-md-12">
            {{ $sliders->links() }}
        </div>
        
      </div>
    </div>
  </div>
</div>
<script>
  @if(session('success'))
      alert("{{ session('success') }}");
      {{ session()->forget('success') }};
  @endif
</script>
@endsection