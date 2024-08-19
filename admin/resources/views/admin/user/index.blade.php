
@extends('layouts.admin')
 
@section('title')
  <title>list users</title>
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
@include('partials.content-header',['name'=> 'user', 'key'=> 'List'])

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <a href="{{ route('users.create') }}" class="btn btn-success float-right m-2">Add</a>
        </div>
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên user</th>
                <th scope="col">email </th>
                <th scope="col">password</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user) 
                <tr>
                    <th scope="row">{{ $user->id }}</th> 
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password }}</td>


                    <td>
                        <a href="{{ route('users.edit',['id'=>$user->id]) }}" class="btn btn-default">Edit</a>
                        <a href="" data-url="{{ route('users.delete',['id'=>$user->id]) }}" class="btn btn-danger action_delete">Delete</a>
                      </td>
                </tr> 
              @endforeach
              <tr>    
            </tbody>
          </table>
        
        </div>
        <div class="col-md-12">
            {{ $users->links() }}
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