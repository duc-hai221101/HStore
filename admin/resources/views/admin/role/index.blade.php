
@extends('layouts.admin')
 
@section('title')
  <title>list role</title>
  <script>
    @yield('scripts')
  </script>
@endsection


@section('js')
 <script src="{{ asset('vendor/sweetAlert2/sweetalert2@11.js') }}"></script>
 <script src="{{ asset('admins/delete.js') }}"></script>
@endsection

@section('content')
<div class="content-wrapper">
@include('partials.content-header',['name'=> 'role', 'key'=> 'List'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <a href="{{ route('roles.create') }}" class="btn btn-success float-right m-2">Add</a>
        </div>
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên vai tro</th>
                <th scope="col">Mo ta</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($roles as $role) 
                <tr>
                    <th scope="row">{{ $role->id }}</th> 
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>
                        <a href="{{ route('roles.edit',['id'=>$role->id]) }}" class="btn btn-default">Edit</a>
                        <a href="" data-url="{{ route('roles.delete', ['id'=> $role->id]) }}" class="btn btn-danger action_delete">Delete</a>
                      </td>
                </tr> 
              @endforeach
              <tr>    
            </tbody>
          </table>
        
        </div>
        <div class="col-md-12">
            {{ $roles->links() }}
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