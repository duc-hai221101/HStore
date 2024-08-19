@extends('layouts.master')

@section('content')
<div class="container">
    <h1>User Profile</h1>
    <p>Name: {{ Auth::user()->name }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
    <!-- Add other user information if needed -->

    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
    <a href="{{ route('profile.orders') }}" class="btn btn-secondary">My Orders</a> <!-- Link to view orders -->
</div>
@endsection
